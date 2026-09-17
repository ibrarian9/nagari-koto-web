<?php

namespace App\Livewire\PublicSite;

use App\Models\SiteVisitor;
use Livewire\Component;

class VisitorCounter extends Component
{
    public function render()
    {
        $onlineCount = SiteVisitor::getOnlineCount(5);
        $todayCount = SiteVisitor::getTodayCount();
        $yesterdayCount = SiteVisitor::getYesterdayCount();
        $monthCount = SiteVisitor::getThisMonthCount();
        $totalCount = SiteVisitor::getTotalCount();
        $totalHits = SiteVisitor::getTotalHits();

        return view('livewire.public.visitor-counter', compact(
            'onlineCount',
            'todayCount',
            'yesterdayCount',
            'monthCount',
            'totalCount',
            'totalHits'
        ));
    }
}
