
	<form id="formRegTBM" action="{{action("FrontController@postTest")}}" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="text" name="test" id="test" />
		<input type="text" name="test2" id="test2" value="{{ old('test2') }}" />
		<input type="submit" value="submit"></input>
	</form>