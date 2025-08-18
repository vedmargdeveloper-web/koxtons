<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>Blog Post </label>
			<textarea rows="5" placeholder="Blog Post" name="postmeta" class="form-control texteditor">{{ old('postmeta') ? old('postmeta') : '' }}</textarea>
			@if( $errors->has('postmeta') )
				<span class="label-warning">{{ $errors->first('postmeta') }}</span>
			@endif
		</div>
	</div>
</div>