<div class="scroll-y mh-325px my-5 px-8">
    <!-- Begin Notifications Items -->
    <div>
        <!-- Begin Notification Item -->
        <div class="py-4">
            <!-- Begin Notification Section -->
            <div class="mb-3">
                <!-- Notification Header -->
                <span class="dropdown-header">{{ $newCount }} Notifications</span>
                <div class="dropdown-divider"></div>

                <!-- Loop through notifications -->
                @foreach($notifications as $notification)
                    <div class="mb-3">
                        @if(isset($notification->data['url']))
                            <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}" class="dropdown-item text-wrap" style="@if ($notification->unread()) font-weight: bold; @endif">
                        @endif

                        @if(isset($notification->data['icon']))
                            <i class="{{ $notification->data['icon'] }} mr-2"></i>
                        @endif

                        @if(isset($notification->data['body']))
                            {{ $notification->data['body'] }}
                        @endif

                        <!-- Notification Timestamp -->
                        <span class="float-right text-muted text-sm">
                            {{ $notification->created_at->longAbsoluteDiffForHumans() }}
                        </span>

                        @if(isset($notification->data['url']))
                            </a>
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                @endforeach
            </div>
            <!-- End Notification Section -->
        </div>
        <!-- End Notification Item -->
    </div>
    <!-- End Notifications Items -->
</div>

<!-- View more link -->
<div class="py-3 text-center border-top">
    <a href="../../demo1/dist/pages/profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">
        View All
        <span class="svg-icon svg-icon-5">
            <!-- SVG Icon Code -->
        </span>
    </a>
</div>
