<?php

namespace App\Workers\Exec;

use App\Workers\Beanstalk\Beanstalk;
use Pheanstalk\Contract\PheanstalkInterface;
use Pheanstalk\Exception\SocketException;
use Pheanstalk\Job;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;


abstract class BeanstalkWorker extends Command
{
    public string $name;
    public string $queueName;
    protected Beanstalk $queue;

    public function __construct(Beanstalk $queue, string $name, string $queueName)
    {
        $this->name = $name;
        $this->queueName = $queueName;
        $this->queue = $queue;
        parent::__construct($this->myName());
    }

    protected function myName(): string
    {
        return $this->name;
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
        echo 'Jod Started ' . $this->name;
        $connect = $this->queue->getConnect();

        while ($job = $connect->watchOnly($this->queueName)->ignore(PheanstalkInterface::DEFAULT_TUBE)->reserve())
        {
            try {
                //Получаю из очереди данные
                $data = $job->getData();

                echo 'Job data' . $data;

                $data = json_decode($job->getData(), true, 512, JSON_THROW_ON_ERROR);

                $this->process($data);

                echo "Job done";
            } catch (Throwable $exception) {
                $this->handleException($exception, $job);
            }
            $connect->delete($job);
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