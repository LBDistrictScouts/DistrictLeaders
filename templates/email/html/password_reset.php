<?php
/**
 * @var \App\Model\Entity\User $entity
 * @var \App\Model\Entity\EmailSend $email_send
 * @var string $token
 * @var \App\View\AppView $this
 */

$action = 'Set New Password';
?>
<p>You are receiving this email because someone requested a password reset on your account.</p>

<p><strong>User Name:</strong> <?= h($entity->username) ?></p>
<p><strong>Full Name:</strong> <?= h($entity->full_name) ?></p>
<?= $this->element('email/token', compact('token', 'action')) ?>



<h3>Actions</h3>
<ul>
    <li></li>
</ul>

<p>This link will work for a week.</p>

<p>Your user was created at <?= $this->Time->i18nFormat($entity->created, 'HH:mm', 'Europe/London') ?> on <?= $this->Time->i18nFormat($entity->created, 'dd-MMM-yy', 'Europe/London') ?>. If this was not you, please email <?= $this->Html->link('info@hertscubs.uk', 'mailto:info@hertscubs.uk') ?>.</p>
<p>We will occasionally contact you from time to time with account notifications (e.g. <span>'your payment has been received'</span>) and with upcoming events. These won't be frequent and you will have the option to unsubscribe.</p>


<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi there,</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>

<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Good luck! Hope it works.</p>
