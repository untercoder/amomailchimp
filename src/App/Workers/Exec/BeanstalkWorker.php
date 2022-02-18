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

        $connect
            ->useTube('testtube')
            ->put("job payload goes here\n");

        $myTestData = [
            "Message" => "Hello world!"
        ];

        $connect
            ->useTube('testtube')
            ->put(
                json_encode($myTestData),  // encode data in payload
                Pheanstalk::DEFAULT_PRIORITY,     // default priority
                10, // delay by 30s
            );

        //Получаю из очереди данные
        $connect->watch('testtube');

        $job = $connect->reserve();

        try {
            $jobPayload = json_decode($job->getData());

            print_r($jobPayload);

            sleep(2);
            $connect->touch($job);
            sleep(2);
            $connect->delete($job);
        }
        catch(\Exception $e) {
            $connect->release($job);
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