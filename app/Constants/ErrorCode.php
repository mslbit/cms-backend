<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("Resource not found")
     */
    public const NOT_FOUND = 404;

    /**
     * @Message("Page slug already exists")
     */
    public const PAGE_SLUG_EXISTS = 1001;

    /**
     * @Message("Block type already exists")
     */
    public const BLOCK_TYPE_EXISTS = 2001;
}
