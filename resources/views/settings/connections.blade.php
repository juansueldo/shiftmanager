<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('user.account')}} <span class="text-muted text-small"> {{ __('user.span_account') }}</span></h3>
      <div class="card">
        <div class="row">
          <div class="col-md-6 col-12">
            <div class="card-header">
              <h5 class="mb-0">Connected Accounts</h5>
              <p class="my-0 card-subtitle">Display content from your connected accounts on your site</p>
            </div>
            <div class="card-body">
              <div class="d-flex mb-4 align-items-center">
                <div class="flex-shrink-0">
                  <img src="{{ asset('img/brands/google.png') }}" alt="google" class="me-4" height="32">
                </div>
                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                  <div class="mb-sm-0 mb-2">
                    <h6 class="mb-0">Google</h6>
                    <small>Calendar and contacts</small>
                  </div>
                  <div class="text-end">
                    <div class="form-check form-switch mb-0">
                      <input type="checkbox" class="form-check-input" {{ $google ? 'checked' : '' }} id="google">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Connections -->
            </div>
          </div>
          <div class="col-md-6 col-12">
            <div class="card-header">
              <h5 class="mb-0">Social Accounts</h5>
              <p class="my-0 card-subtitle">Display content from social accounts on your site</p>
            </div>
            <div class="card-body">
              <!-- Social Accounts -->
             
               
              </div>
              <!-- /Social Accounts -->
            </div>
          </div>
        </div>
      </div>
      </div>