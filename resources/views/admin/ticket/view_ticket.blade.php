@extends('layouts.app')

@section('content')
<div class="container">
     <div class="card ">
     <div class="card-header card-info">
            <h4 style="font-style: italic;">Your Ticket Details.</h4>
        </div>
    <div class="card-body">
         <div class="row">
            <div class="col-md-8">
                <strong>Name: <span class="text-muted">{{ $ticket->name }}</span></strong><br>
                <strong>Subject: <span class="text-muted">{{ $ticket->subject }}</span></strong><br>
                <strong>Service: <span class="text-muted">{{ $ticket->service }}</span></strong><br>
                <strong>Prortity: <span class="text-muted">{{ $ticket->prortity }}</span></strong><br>
                <strong>Message: <span class="text-muted">{{ $ticket->message }}</span></strong>
            </div>
            <div class="col-md-4">
                <a href="{{ asset($ticket->image) }}" target="_blank"><img src="{{ asset($ticket->image) }}" alt="" style="height: 100px; width: 100px;"></a>
            </div>
         </div>
    </div>
  </div><br>

  <div class="row">
    <div class="col-md-6">
       <div class="card">
          <div class="card-header bg-info">{{ __('Reply Massage') }}</div>
              
              <div class="card-body">
                 <form action="{{ route('admin.store.reply') }}" method="post" enctype="multipart/form-data">
                  @csrf
                    <div class="form-group">
                      <label for="exampleInputPassword1" class="form-label">Message</label>
                      <textarea name="message" class="form-control" required></textarea>
                    </div>
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="form-group">
                      <label for="exampleInputPassword1" class="form-label">Image</label>
                      <input type="file" name="image" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-info">Replies Ticket</button>
                  </form>
                  
              </div>

          </div><br>
           <a href="{{ route('admin.close.ticket',$ticket->id) }}" class="btn btn-danger" style="float:right;">Close Reply</a>
      </div>
      {{-- Reply Message showing --}}
      @php
      $reply=DB::table('order_replies')->where('ticket_id',$ticket->id,)->orderBy('id',"DESC")->get();
      @endphp
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-info">
              <strong style="font-style: italic;">All Replies.</strong>
          </div>
          <div class="card-body" style="height: 400px; overflow-y: scroll;">
            @isset($reply)
            @foreach($reply as $row)
              <div class="card mt-2 @if($row->user_id==0) ml-4 @endif">
                <div class="card-header @if($row->user_id==0) bg-info @else bg-danger @endif">
                  <i class="fa-solid fa-user"></i> @if($row->user_id==0)Admin @else{{ $ticket->name }}@endif
                </div>
                <div class="card-body">
                  <blockquote class="blockquote mb-0">
                    <p>{{ $row->message }}</p>
                    <footer class="blockquote-footer">{{ date('d F Y',strtotime($row->date)) }}</footer>
                  </blockquote>
                </div>
              </div>
              @endforeach
              @endisset
          </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
