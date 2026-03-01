<style>
body {
    background-color: #f5f7fb;
}

.feed-card {
    border: none;
    border-radius: 3px;
    background: #ffffff;
    padding: 20px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);

}

.feed-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.feed-avatar {
    width: 48px;
    height: 48px;
    object-fit: cover;
}

.feed-title {
    font-weight: 600;
    font-size: 16px;
}

.feed-time {
    font-size: 13px;
    color: #8c8c8c;
}

.sidebar-card {
    border: none;
    border-radius: 16px;
    background: #ffffff;
    padding: 20px;
}
@media (min-width: 768px)  {
    #content_diplay_col{
        overflow-y: scroll;
        max-height : 500px;
    }
    body{
        overflow: hidden;
    }
}
</style>
<div class="container-fluid mt-4 px-4">
    <div class="row g-4">

        <!-- LEFT SIDE - FEED -->
        <div class="col-lg-9" id="content_diplay_col"  style="">

            @foreach($data as $feed)
            <div class="feed-card mb-4">

                <!-- Header -->
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($feed->user->name ?? 'Admin') }}"
                         class="rounded-circle me-3 feed-avatar">

                    <div>
                        <div class="feed-title">
                            {{ $feed->user->name ?? 'Admin' }}
                        </div>

                        <div class="feed-time">
                           
                            <small >
                                {{ $feed->created_at->diffForHumans() }} | 
                                 {{ $feed->created_at->format('F d, Y \a\t h:i A') }} 
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="mt-3 text-dark" style="line-height: 1.6;">
                    {{ $feed->content }}
                </div>


            </div>
            <hr>
            @endforeach

        </div>

        <!-- RIGHT SIDE - SIDEBAR -->
        <div class="col-lg-3">

            <!-- Celebrations -->
            <div class="sidebar-card mb-4">
                <h6 class="fw-bold mb-3">Birthday Today!</h6>

                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name=Anne"
                         class="rounded-circle me-2" width="35">
                    <div>
                        <div class="fw-semibold">Anne Dominique</div>
                        <small class="text-muted">31 years old!</small>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=Arthur"
                         class="rounded-circle me-2" width="35">
                    <div>
                        <div class="fw-semibold">Arthur Falcotelo</div>
                        <small class="text-muted">31 years old!</small>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="sidebar-card">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <button class="btn btn-light w-100 mb-2">📄 Documents</button>
                <button class="btn btn-light w-100">ℹ Information</button>
            </div>

        </div>

    </div>
</div>