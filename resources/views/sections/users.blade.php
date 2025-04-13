<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Users <span class="text-muted text-small">/ Manage your accounts</span></h3>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Users</h5>
            <div class="d-flex justify-content-end">
            <button class="btn btn-primary waves-effect waves-light"  
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasEnd"
            aria-controls="offcanvasEnd"
            data-ajax-source="/users/form"
            data-ajax-method="replaceHtml"
            data-ajax-container="#offcanvasEnd"
            ><i class="ri-add-line"></i> Add new users</button>
            </div>
        </div>
        <div class="card-body">
            @include('layouts.partials.table',['table' => $table])
        </div>
    </div>
</div>

@include('layouts.partials.alert', ['session'=> $session ?? ''])