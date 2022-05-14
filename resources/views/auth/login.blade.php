@extends('auth.contenido')

@section('login')
<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
        {{ csrf_field() }}
				<img src="img/avatar.svg">
				<h2 class="title">¡Bienvenido!</h2>
           		<div class="input-div one{{$errors->has('usuario' ? 'is-invalid' : '')}}">
           		   <div class="i">
           		   		<i class="fa fa-user-o"></i>
           		   </div>
           		   <div class="div">
           		   		<input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="input" placeholder="Usuario">
           		   </div>
           		</div>
               
               <div>
                {!!$errors->first('usuario', '<span class="text-danger">:message</span>')!!}
              </div>
              
           		<div class="input-div pass{{$errors->has('password' ? 'is-invalid' : '')}}">
           		   <div class="i"> 
           		    	<i class="fa fa-unlock-alt"></i>
           		   </div>
           		   <div class="div">
           		    	<input type="password" name="password" id="password" class="input" placeholder="Password">
            	   </div>
            	</div>
              <br>
              <div>
                {!!$errors->first('password', '<span class="text-danger">:message</span>')!!}
              </div>
            	<button type="submit" class="btn">Acceder</button>
            </form>
        </div>
    </div>
@endsection
