<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var AppView $this
 * @var Notification $notification
 * @var string $token
 */

use App\Model\Entity\Notification;
use App\View\AppView;

?>
<?= $this->cell('Information::email', [$notification]) ?>
<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
    <tbody>
        <tr>
            <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                    <tbody>
                    <tr>
                        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;">
                            <?= $this->Html->link('Set your Username & Password', ['_full' => true, 'controller' => 'Tokens', 'action' => 'validate', 'prefix' => false, $token], ['class' => 'btn btn-success', 'target' => '_blank', 'style' => 'display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;']) ?>
                        </td>
                    </tr>
                    <div class="card-footer">

                    </div>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

