<div class="chat-history-footer shadow-xs">
  <form class="form-send-message d-flex justify-content-between align-items-center"
        data-ajax-source="/chat/send"
        data-ajax-form="true"
        data-ajax-validated="true">
        
    @csrf
    
    <input class="form-control message-input border-0 me-4 shadow-none" 
          name="message" 
          id="message"
          suggest="off"
          placeholder="Type your message here..." />
    
    <div class="message-actions d-flex align-items-center">
      <span class="btn btn-text-secondary btn-icon rounded-pill cursor-pointer waves-effect">
        <i class="speech-to-text icon-base ri ri-mic-line icon-md text-heading"></i>
      </span>
      
      <label for="attach-doc" class="form-label mb-0">
        <span class="btn btn-text-secondary btn-icon rounded-pill cursor-pointer mx-1 waves-effect">
          <i class="icon-base ri ri-attachment-2 icon-md text-heading"></i>
        </span>
        <input type="file" id="attach-doc" hidden="">
      </label>
      
      <button type="submit" class="btn btn-primary d-flex send-msg-btn waves-effect waves-light">
        <span class="align-middle d-md-inline-block d-none">Send</span>
        <i class="icon-base ri ri-send-plane-line icon-sm ms-md-2 ms-0"></i>
      </button>
    </div>
  </form>
</div>
