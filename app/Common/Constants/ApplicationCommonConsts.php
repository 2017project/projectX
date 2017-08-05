<?php

namespace App\Common\Constants;

/**
 * Class ApplicationCommonConsts
 * @package App\Common\Constants
 */
class ApplicationCommonConsts
{
    public static $MAIL_STATUS_SUCCESS_CODE = 0;
    public static $MAIL_STATUS_FAILED_CODE = 1;

    public static $MAIL_MARK_UNREAD = 1;
    public static $MAIL_MARK_READ = 2;
    public static $MAIL_MARK_STARRED = 3;

    // ****************** MAIL FILTER ******************* //
    public static $MAIL_FILTER_MARK_ALL = 0;
    
    public static $MAIL_FILTER_DEST_INBOX= 1;
    public static $MAIL_FILTER_DEST_OUTBOX = 2;
    public static $MAIL_FILTER_DEST_ALL = 0;

    public static $MAIL_FILTER_DATE_FROM_ALL = NULL;
    public static $MAIL_FILTER_DATE_TO_ALL = NULL;

    public static $MAIL_FILTER_PHRASE_ALL = "";

    public static $MAIL_FILTER_USERNAME_ALL = "";

    public static $MAIL_FILTER_ITEMS_PER_PAGE_ALL = -1;
    // ************************************************* //

    public static $MAIL_THREAD_DEFAULT = -1;
}