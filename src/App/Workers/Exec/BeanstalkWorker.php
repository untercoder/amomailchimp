<?php

namespace App\Workers\Exec;

use App\Workers\Beanstalk\Beanstalk;
use Pheanstalk\Exception\SocketException;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;


abstract class BeanstalkWorker extends Command
{
    public const NAME = '';
    public const QUEUE = '';

    protected Beanstalk $queue;

    public function __construct(Beanstalk $queue)
    {
        $this->queue = $queue;
        parent::__construct($this->myName());
    }

    protected function myName(): string
    {
        return self::NAME;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        echo 'Jod Started ' . static::NAME;

        $connect = $this->queue->getConnect();

        try {
            // Слушаем сообщения из очереди по имени QUEUE
            while ($job = $connect->watchOnly(static::QUEUE)->ignore(PheanstalkInterface::DEFAULT_TUBE)->reserve()) {
                try {

                    $data = $job->getData();

                    echo 'Jod data' . $data;

                    $data = json_decode($job->getData(), true, 512, JSON_THROW_ON_ERROR);

                    // Вызываем абстраактный метод обработки, каждый воркер будет обрабатывать запросы по своему
                    $this->process($data);

                    echo "Job done";
                } catch (Throwable $exception) {
                    $this->handleException($exception, $job);
                }

                $connect->delete($job);
            }
        } catch (Throwable $exception) {
            $this->handleBeanstalkException($exception);
        }

        return 0;
    }

    /**
     * Абстрактнаая реализация обработчки ошибки
     * @param Throwable $exception
     */
    protected function handleBeanstalkException(Throwable $exception): void
    {
        // ловим ошибки на уровне beanstalk
        if (
            !$exception instanceof SocketException
            || !str_contains($exception->getMessage(), 'timed out')
        ) {
            echo 'Error' . $exception;
        }
    }

    /**
     * @param Throwable $exception
     * @param Job $job
     */
    private function handleException(Throwable $exception, Job $job): void
    {
        echo 'Error Unhandled exception' . $exception . "\n" . $job->getData();
    }

    abstract protected function process(array $job): void;
}