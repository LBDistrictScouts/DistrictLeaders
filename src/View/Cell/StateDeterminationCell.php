<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\User;
use App\Model\Entity\UserState;
use Cake\View\Cell;

/**
 * StateDetermination cell
 *
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \App\View\Helper\IconHelper $Icon
 * @property \App\Model\Table\UserStatesTable $UserStates
 */
class StateDeterminationCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_validCellOptions = [];

    /**
     * @var array<string>  Helper Array
     */
    public array $helpers = [
        'Html',
        'Icon',
    ];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @param \App\Model\Entity\User $user User for Determining State
     * @return void
     */
    public function display(User $user): void
    {
        $this->loadModel('UserStates');

        $signature = $this->UserStates->evaluateUser($user);

        $evaluationArray = [
            'Username' => UserState::EVALUATE_USERNAME,
            'Has Logged In' => UserState::EVALUATE_LOGIN_EVER,
            'Has Logged In Recently' => UserState::EVALUATE_LOGIN_QUARTER,
            'Has Login Capability' => UserState::EVALUATE_LOGIN_CAPABILITY,
            'Active Role' => UserState::EVALUATE_ACTIVE_ROLE,
            'Validated Email' => UserState::EVALUATE_VALIDATED_EMAIL,
            'Activated' => UserState::EVALUATE_ACTIVATED,
        ];

        $userStateArray = [];

        foreach ($evaluationArray as $evaluation => $binary) {
            $userStateArray[$evaluation] = (bool)(($signature & $binary) > 0);
        }

        $this->set(compact('userStateArray', 'user'));
    }
}
