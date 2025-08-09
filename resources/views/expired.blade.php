@if (auth()->user()->organization && now()->gt(auth()->user()->organization->end_date))
    <div class="alert alert-danger">Your plan has expired.</div>
@endif
