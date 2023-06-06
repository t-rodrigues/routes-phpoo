<?php

namespace app\support;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private string|array $to;
    private string $from;
    private string $fromName;
    private string $subject;
    private string $template;
    private array $templateData;
    private string $message;
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer();
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;
        $this->mailer->Host     = env('EMAIL_HOST');
        $this->mailer->Port     = env('EMAIL_PORT');
        $this->mailer->Username = env('EMAIL_USERNAME');
        $this->mailer->Password = env('EMAIL_PASSWORD');
        $this->mailer->CharSet  = 'UTF-8';
    }

    public function from(string $from, string $fromName = ''): Email
    {
        $this->from = $from;
        $this->fromName = $fromName;
        return $this;
    }

    public function to(string|array $to): Email
    {
        if (empty($to)) {
            throw new Exception("alksdfjalsdkfjasl");
        }
        $this->to = $to;
        return $this;
    }

    public function template(string $template, array $templateData): Email
    {
        $this->template = $template;
        $this->templateData = $templateData;
        return $this;
    }

    public function subject(string $subject): Email
    {
        $this->subject = $subject;
        return $this;
    }

    public function message($message): Email
    {
        $this->message = $message;
        return $this;
    }

    public function send(): bool
    {
        try {
            $this->mailer->setFrom($this->from, $this->fromName);
            $this->addAddress();
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $this->subject;
            $this->mailer->Body = empty($this->template) ? $this->message : $this->sendWithTemplate();
            $this->mailer->AltBody = $this->message;
            return $this->mailer->send();
        } catch (Exception $_) {
            dd("Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
        }
    }

    private function addAddress(): void
    {
        if (is_array($this->to)) {
            foreach ($this->to as $to) {
                $this->mailer->addAddress($to);     //Add a recipient
            }
        }

        if (is_string($this->to)) {
            $this->mailer->addAddress($this->to);
        }
    }

    private function sendWithTemplate(): string
    {
        $file = '../app/views/emails/' . $this->template . '.html';
        if (!file_exists($file)) {
            throw new Exception("invalid template: {$this->template}");
        }
        $template = file_get_contents($file);
        $this->templateData['message'] = $this->message;
        foreach ($this->templateData as $key => $value) {
            $dataTemplate["@{$key}"] = $value;
        }
        return str_replace(array_keys($dataTemplate), array_values($dataTemplate), $template);
    }
}
