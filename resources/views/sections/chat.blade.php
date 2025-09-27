@vite([
  'resources/js/app-chat.js',
])
<div class="container-xxl flex-grow-1 container-p-y">
          
          <div class="app-chat card overflow-hidden">
            <div class="row g-0">
              <!-- Sidebar Left -->
              <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-5 pt-12">
                  <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                    <img src="{{ asset( $user->avatar) }}" alt="Avatar" class="rounded-circle" />
                  </div>
                  <h5 class="mt-4 mb-0">John Doe</h5>
                  <span>UI/UX Designer</span>
                  <i class="icon-base ri ri-close-line icon-20px cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
                </div>
              
              </div>
              <!-- /Sidebar Left-->
        
              <!-- Chat & Contacts -->
              <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                <div class="sidebar-header px-5 border-bottom d-flex align-items-center">
                  <div class="d-flex align-items-center me-6 me-lg-0">
                    <div class="flex-shrink-0 avatar avatar-online me-4" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                      <img class="user-avatar rounded-circle cursor-pointer" src="{{ asset( $user->avatar) }}" alt="Avatar" />
                    </div>
                    <div class="flex-grow-1 input-group input-group-sm input-group-merge rounded-pill">
                      <span class="input-group-text" id="basic-addon-search31"><i class="icon-base ri ri-search-line icon-20px"></i></span>
                      <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
                    </div>
                  </div>
                  <i class="icon-base ri ri-close-line icon-lg cursor-pointer position-absolute top-50 end-0 translate-middle d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                </div>
                <div class="sidebar-body">
                  <!-- Chats -->
                  <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                    @foreach ($customers as $customer)
                    <li class="chat-contact-list-item mb-1" data-ajax-source="/chat/start/{{ $customer->id }}" data-ajax-method="replaceHtml" data-ajax-container="div#app-chat-conversation" data-ajax-then="updateBox"> 
                      <a class="d-flex align-items-center">
                        <div class="flex-shrink-0 avatar avatar-online">
                        <span class="avatar-initial rounded-circle bg-label-success">
                          {{ substr($customer->firstname, 0, 1) }}{{ substr($customer->lastname, 0, 1) }}
                        </span>
                        </div>
                        <div class="chat-contact-info flex-grow-1 ms-4">
                          <div class="d-flex justify-content-between align-items-center">
                            <h6 class="chat-contact-name text-truncate m-0 fw-normal">{{ $customer->firstname }} {{ $customer->lastname }}</h6>
                            <small class="chat-contact-list-item-time">5 Minutes</small>
                          </div>
                          <small class="chat-contact-status text-truncate">Refer friends. Get rewards.</small>
                        </div>
                      </a>
                    </li>
                    @endforeach
                  </ul>          
                </div>
              </div>
              <!-- /Chat contacts -->
        
              <!-- Chat conversation -->
              <div class="col app-chat-conversation d-flex align-items-center justify-content-center flex-column" id="app-chat-conversation">
                <div class="bg-label-primary p-8 rounded-circle">
                  <i class="icon-base ri ri-wechat-line icon-48px"></i>
                </div>
                <p class="my-4">Select a contact to start a conversation.</p>
                <button class="btn btn-primary app-chat-conversation-btn" id="app-chat-conversation-btn">Select Contact</button>
              </div>
              <!-- /Chat conversation -->
        
            
             
        
              <div class="app-overlay"></div>
            </div>
          </div>
        
                </div>
