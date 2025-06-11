<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('connections.title')}} <span class="text-muted text-small"> {{ __('connections.span') }}</span></h3>
        <div class="row">
          <div class="col-5 card me-2">
            <div class="card-header">
              <h5 class="mb-0">{{ __('connections.connected_accounts') }}</h5>
              <p class="my-0 card-subtitle">{{ __('connections.description_connected') }}</p>
            </div>
            <div class="card-body">
              <div class="d-flex mb-4 align-items-center">
                <div class="flex-shrink-0">
                  <img src="{{ asset('img/brands/google.png') }}" alt="google" class="me-4" height="32">
                </div>
                <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                  <div class="mb-sm-0 mb-2">
                    <h6 class="mb-0">{{ __('connections.google') }}</h6>
                    <small>{{ __('connections.google_description') }}</small>
                  </div>
                  <div class="text-end">
                    <div class="form-check form-switch mb-0">
                      <input type="checkbox" class="form-check-input" {{ $google ? 'checked' : '' }} onclick="return false;" id="google">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Connections -->
            </div>
          </div>
          <div class="col-6 card ms-2">
            <div class="card-header">
              <h5 class="mb-0">{{__('connections.google')}}</h5>
              <p class="my-0 card-subtitle">{{__('connections.google_account')}}</p>
            </div>
            <div class="card-body">
              <!-- Social Accounts -->
              @if($google == '')
                <a href="{{ route('auth.google') }}" class="btn btn-outline-primary d-grid w-100 mb-4">
                  <div class="d-flex align-items-center justify-content-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" class="me-2">
                      <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                      <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                      <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                      <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    {{__('connections.google_connect')}}
                  </div>
                </a>
              @else
                <a href="#" data-ajax-source="/auth/google/disconnect" data-ajax-method="replaceHtml" data-ajax-container="span#content-wrapper" class="btn btn-outline-primary d-grid w-100 mb-4">
                  <div class="d-flex align-items-center justify-content-center">
                    <svg width="18" height="18" viewBox="0 0 24 24" class="me-2">
                      <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                      <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                      <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                      <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    {{__('connections.google_disconnect')}}
                  </div>
                </a>
              @endif
              </div>
              <!-- /Social Accounts -->
            </div>
          </div>
        </div>

      </div>
      @include('layouts.partials.alert', ['session'=> $session ?? ''])