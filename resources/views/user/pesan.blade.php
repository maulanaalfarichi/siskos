@extends('layouts.user.page')

@section('title')
	Pesan
@endsection

@section('contents')
	<h3>Pesan</h3>
	@if(count($chat) == 0 && !isset($new))
		<div class="alert alert-info">
			<p>Anda belum memiliki pesan apapun</p>
		</div>
	@else
	<div class="row">
		<div class="col-lg-4" id="message-user">
			<ul>
			@if(isset($new))
				<li id="{{ $new->id }}" class="active">
					<img src="{{ asset('storage/' . $new->avatar) }}"/>
					<h5>{{ substr($new->username,0,20) }}</h5>
				</li>
			@endif
			@foreach($chat as $detail)
				@if($detail->id != Auth::user()->id)
				<li id="{{ $detail->id }}">
					<img src="{{ asset('storage/' . $detail->avatar) }}"/>
					<h5>{{ substr($detail->username,0,20) }}</h5>
				</li>
				@endif
			@endforeach
			</ul>
		</div>
		
		<div class="col-lg-8" style="padding:0">
			<div class="message-content">
				<div id="message-list">
					<div class="alert alert-info">
						<p style="text-align:center">
							<i class="fa fa-comments fa-5x"></i>
						</p>
						<p>Perlu informasi dari pengguna lain ? Ayo, mengobrol dengan mereka sekarang</p>
					</div>
				</div>
				<form id="form-chat" action="{{ route('kirim.pesan') }}" method="POST" style="display:none">
				<div class="input-group">
				<input type="hidden" name="to" id="to" value="{{ isset($new) ? $new->id : '' }}"/>
					{{ csrf_field() }}
					<input type="text" name="message" placeholder="Ketikkan Pesan.."/>
					<div class="input-group-btn">
					<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endif
@endsection