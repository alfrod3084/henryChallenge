<?php

namespace App\Helpers;

use App\Models\Rule;
use App\Models\User;

class RuleEvaluator
{
    public static function evaluate(User $user, $ruleSet): bool
    {
        if (!empty($ruleSet)) {
            foreach ($ruleSet as $key => $rule) {
                $field = $rule->field;
                $operator = $rule->operator;
                $expectedValue = $rule->value;
                $actualValue = data_get($user, $field);
                $decision = match ($operator) {
                    "==" => $actualValue == $expectedValue,
                    "!=" => $actualValue != $expectedValue,
                    ">" => $actualValue > $expectedValue,
                    "<" => $actualValue < $expectedValue,
                    "in" => in_array($expectedValue),
                    "not_in" => !in_array($expectedValue),
                    "contains" => str_contains($actualValue, $expectedValue),
                    default => false
                };
                if (!$decision) {
                    return false;
                } 
            }
        } else {
            return false;
        }
        return true;
    }

    public static function test()
    {
        echo "Rules \n";
        $userP = Rule::first();
        print_r(json_decode($userP->actions)) . "\n";

        echo "Test 1 - Create new user as role staff \n";
        $user = new User();
        $user->role = "staff";
        $user->email_verified_at = now();

        $canDo = self::evaluate($user, json_decode($userP->actions)->rules);
        echo "this user can " . json_decode($userP->actions)->action . ": " . ($canDo ? "YES" : "NO") . "\n";

        echo "Test 2 - Create new user as role admin \n";
        $user = new User();
        $user->role = "admin";
        $user->email_verified_at = now();

        $canDo = self::evaluate($user, json_decode($userP->actions)->rules);
        echo "this user can " . json_decode($userP->actions)->action . ": " . ($canDo ? "YES" : "NO"). "\n";

        echo "Test 3 - Create new user as role staff but email was not verified \n";
        $user = new User();
        $user->role = "staff";
        $user->email_verified_at = null;

        $canDo = self::evaluate($user, json_decode($userP->actions)->rules);
        echo "this user can " . json_decode($userP->actions)->action . ": " . ($canDo ? "YES" : "NO"). "\n";
    }
}
