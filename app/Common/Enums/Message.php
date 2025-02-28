<?php

namespace App\Common\Enums;

enum Message
{
    const WRONG_CREDENTIALS = 'credentialsNotCorrect';

    const PHONE_SHOULD_NOT_CONTAIN_LETTERS = 'phoneNumberShouldNotHasLetters';

    const EMPTY_PASSWORD = 'Password not found.';

    const PASSWORD_NOT_MATCHING = 'Password not match.';

    const PASSWORD_CHANGED = 'Success change password.';

    const YOU_NEED_TO_RESET_YOUR_PASSWORD = 'You need to reset your password.';

    const USER_NOT_FOUND = 'User not found.';

    const EMAIL_ALREADY_VERIFIED = 'User email already verified.';

    const INVALID_EMAIL_VERIFICATION = 'Invalid email verification.';

    const USER_EMAIL_NOT_FOUND = 'User email not found';

    const EMAIL_VERIFICATION_SENT = 'Email verification has been sent successfully';

    const FREEEMAILPROVIDERSARENOTALLOWED = 'Free email providers are not allowed.';

    const EMAIL_IS_NOT_VERIFIED = 'Email is not verified.';

    const EMAIL_IS_VERIFIED = 'Email is verified.';

    const EMAIL_SENT_WITH_FORGET_CODE = 'Email sent with forget code.';

    const CONTACT_TO_US_IS_SENT = 'Contact to us is sent';
}
