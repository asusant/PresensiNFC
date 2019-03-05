  @foreach ($errors->all() as $message) 
      <div class="alert alert-danger alert-dismissable">
          {{ $message }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @endforeach
  @if(session()->has('message_sukses'))
      <div class="alert alert-success alert-dismissable">
          {{ session()->get('message_sukses') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @endif
  @if(session()->has('message_warning'))
      <div class="alert alert-warning">
          {{ session()->get('message_warning') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @endif
  @if(session()->has('message_danger'))
      <div class="alert alert-danger">
          {{ session()->get('message_danger') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @endif
  @if(session()->has('message_primary'))
      <div class="alert alert-primary">
          {{ session()->get('message_primary') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
  @endif