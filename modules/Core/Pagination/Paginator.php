<?php
/**
 * Created by ngocnh.
 * Date: 8/6/15
 * Time: 11:39 AM
 */

namespace Modules\Core\Pagination;

use Landish\Pagination\ZurbFoundation;

class Paginator extends ZurbFoundation
{

    /**
     * Pagination wrapper HTML.
     *
     * @var string
     */
    protected $paginationWrapper = '<ul class="pagination">%s %s %s</ul>';

    /**
     * Available page wrapper HTML.
     *
     * @var string
     */
    protected $availablePageWrapper = '<li><a href="%s">%s</a></li>';

    /**
     * Get active page wrapper HTML.
     *
     * @var string
     */
    protected $activePageWrapper = '<li class="active"><span>%s</span></li>';

    /**
     * Get disabled page wrapper HTML.
     *
     * @var string
     */
    protected $disabledPageWrapper = '<li class="disabled"><span>%s</span></li>';

    /**
     * Previous button text.
     *
     * @var string
     */
    protected $previousButtonText = '&laquo;';

    /**
     * Next button text.
     *
     * @var string
     */
    protected $nextButtonText = '&raquo;';

    /***
     * "Dots" text.
     *
     * @var string
     */
    protected $dotsText = '...';
}