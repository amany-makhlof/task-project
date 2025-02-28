<?php

namespace App\Common\Enums;

enum RouteName
{
    const LOGIN = 'api.login';

    const REGISTER = 'api.register';

    const TOPUP = 'api.topup';

    const TRANSFER = 'api.transfer';

    const TRANSACTIONS = 'api.transactions';

    const BALANCE = 'api.balance';

    const LOGOUT = 'api.logout';
}
