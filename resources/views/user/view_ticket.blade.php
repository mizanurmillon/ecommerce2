@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('user.sidebar')
        <div class="col-md-8">
            <div class="card">
                 <div class="card-header">
                        <h4 style="font-style: italic;">Your Ticket Details.</h4>
                    </div>
                <div class="card-body">
                     <div class="row">
                        <div class="col-md-8">
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
            </div>
            {{-- Reply Message showing --}}
            @php
            $reply=DB::table('order_replies')->where('ticket_id',$ticket->id,)->orderBy('id',"DESC")->get();
            @endphp
            <div class="card mt-2">
                <div class="card-header">
                    <strong style="font-style: italic;">Submit your ticket we will reply.</strong>
                </div>
                <div class="card-body" style="height: 400px; overflow-y: scroll;">
                  @isset($reply)
                  @foreach($reply as $row)
                    <div class="card mt-2 @if($row->user_id==0) ml-4 @endif">
                      <div class="card-header @if($row->user_id==0) bg-info @else bg-danger @endif">
                        <i class="fa-solid fa-user"></i> @if($row->user_id==0)Admin @else{{ Auth::user()->name }}@endif
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
            <div class="card mt-2">
                <div class="card-header">{{ __('Reply Massage') }}</div>
                    
                    <div class="card-body">
                       <strong style="font-style: italic;">Submit your ticket we will reply.</strong><hr>
                       <form action="{{ route('reply.ticket') }}" method="post" enctype="multipart/form-data">
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
                          
                          <button type="submit" class="btn btn-info">Submit Ticket</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
