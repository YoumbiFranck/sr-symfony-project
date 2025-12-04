<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:send-email',
    description: 'send an email to someone',
)]
class SendEmailCommand extends Command
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('recipient', InputArgument::REQUIRED, 'e-mail recipient');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $recipient = $input->getArgument('recipient');

        try {
            $email = (new Email())
                ->from('noreply@example.com')
                ->to($recipient)
                ->subject('Test E-Mail from Symfony')
                ->text('This is a test email.')
                ->html('<p>This <strong>e-mail </strong> is send from Symfony.</p>');

            $this->mailer->send($email);

            $io->success(sprintf('E-mail send : %s', $recipient));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error(sprintf('Error while sending the email : %s', $e->getMessage()));

            return Command::FAILURE;
        }
    }
}
