<?php

declare(strict_types=1);

namespace JCIT\widgets\input;

use kartik\password\PasswordInput as KartikPasswordInput;
use kartik\password\StrengthValidator;
use yii\BaseYii;
use yii\helpers\Html;

class PasswordInput extends KartikPasswordInput
{
    public bool $showRules = true;

    public function run(): string
    {
        $result = parent::run();

        if ($this->showRules) {
            $rules = [];

            $validators = $this->model->getActiveValidators($this->attribute);
            $attributeLabel = $this->model->getAttributeLabel($this->attribute);

            foreach ($validators as $validator) {
                if ($validator instanceof StrengthValidator) {
                    if ($validator->min > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at least {number} {n, plural, =1{character} other{characters}}',
                            [
                                'number' => $validator->min,
                                'n' => $validator->min,
                            ]
                        );
                    }

                    if ($validator->max > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at max {number} {n, plural, =1{character} other{characters}}',
                            [
                                'number' => $validator->max,
                                'n' => $validator->max
                            ]
                        );
                    }

                    if ($validator->lower > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at least {number} lowercase {n, plural, =1{character} other{characters}}',
                            [
                                'number' => $validator->lower,
                                'n' => $validator->lower,
                            ]
                        );
                    }

                    if ($validator->upper > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at least {number} uppercase {n, plural, =1{character} other{characters}}',
                            [
                                'number' => $validator->upper,
                                'n' => $validator->upper,
                            ]
                        );
                    }

                    if ($validator->digit > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at least {number} {n, plural, =1{digit} other{digits}}',
                            [
                                'number' => $validator->digit,
                                'n' => $validator->digit,
                            ]
                        );
                    }

                    if ($validator->special > 0) {
                        $rules[] = BaseYii::t(
                            'JCIT',
                            'at least {number} special {n, plural, =1{character} other{characters}}',
                            [
                                'number' => $validator->digit,
                                'n' => $validator->digit,
                            ]
                        );
                    }

                    break;
                }
            }

            $result .= Html::tag(
                'div',
                Html::tag('div', BaseYii::t(
                    'JCIT',
                    '{attribute} must comply the following rules:',
                    ['attribute' => $attributeLabel]
                )) . Html::ul($rules, ['class' => ['mb-0']]),
                ['class' => ['hint-block', 'password-rules']]
            );
        }

        return $result;
    }
}
