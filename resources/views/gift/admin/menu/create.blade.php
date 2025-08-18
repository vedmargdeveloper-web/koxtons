@extends( admin_app() )


@section('content')


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="card">

      <div class="card-header">
        <h4>{{ $title }}</h4>
      </div>

      <div class="card-body pt-4">
        
        <div class="row nav-tabs-custom">
              <?php $menus = App\model\Post::where('type', 'menu')->get(); ?>
              <?php $selected = isset( $_GET['menu_name'] ) ? $_GET['menu_name'] : '' ; ?>
              
              @if( $menus )
                <div class="col-md-6 form-container">              
                  {{ Form::open( ['url' => route('menu.index', 'menu'), 'method' => 'GET'] ) }}
                  <div class="row">
                  <div class="col-md-3 text-center"><label>Menus:</label></div>
                  <div class="col-md-5">                    
                    <select class="form-control" name="menu_name">
                      <option value="">Select</option>
                        @foreach( $menus as $m )
                          <option {{ $selected === $m->title ? 'selected="selected' : '' }} value="{{ $m->title }}">{{ $m->title }}</option>
                        @endforeach
                    </select>                    
                  </div>
                  <div class="col-md-2"><button type="submit" class="btn btn-primary">Select</button></div>
                  </div>
                  {{ Form::close() }}
                </div>
              @endif

              <div class="col-md-6 form-container">
                {{ Form::open( ['url' => route('menu.index', 'menu'), 'method' => 'GET'] ) }}
                  <div class="row">
                    <div class="col-md-3">Create Menu: </div>
                    <div class="col-md-5">
                    <?php $menu = isset( $_GET['menu_name'] ) ? $_GET['menu_name'] : '' ; ?>
                    <input type="text" name="menu_name" required class="form-control" value="{{ $menu }}" placeholder="Menu name"></div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary">Create</button></div>
                  </div>
                {{ Form::close() }}
              </div>
        </div>

            <div class="col-md-12">

                @if( Session::has('menu_err') )
                  <span class="error label-warning">{{ Session::get('menu_err') }}</span>
                @endif

                @if( Session::has('menu_msg') )
                  <span class="error label-success">{{ Session::get('menu_msg') }}</span>
                @endif

                <?php $menu = App\model\Post::where(['title' => $selected, 'type' => 'menu'])->first(); ?>

                <div class="box-body nav-tabs-custom">

                  <div class="row">
                  
                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 selector">
                      
                      <div>
                          <label>Category</label>
                      </div>                    
                      <div class="dd mb-2" id="nestable2">
                          <ol class="dd-list item-holder">
                              
                              <?php $category = App\model\Category::all(); ?>

                              @if( $category )

                                @foreach( $category as $row )
                                    <li class="dd-item" data-type="category" data-name="{{ $row->name }}" data-slug="{{ $row->slug }}" data-id="{{ $row->id }}"><div class="dd-handle">{{ ucfirst($row->name) }}</div></li>
                                  
                                @endforeach

                              @endif

                          </ol>
                      </div>
                      
                    
                      <div>
                          <label>Page</label>
                      </div> 
                        
                      <div class="dd" id="nestable3">
                          <ol class="dd-list item-holder">
                              <?php $pages = App\model\Post::where(['type' => 'page'])->get(); ?>

                              @if( $pages )

                                @foreach( $pages as $row )
                                  
                                    <li class="dd-item" data-type="page" data-slug="{{ $row->slug }}" data-id="{{ $row->id }}"><div class="dd-handle">{{ ucfirst($row->title) }}</div></li>

                                @endforeach

                              @endif
                          </ol>
                      </div>

                      <div>
                          <label>Custom Link</label>
                      </div> 
                        
                      <div class="form-group">
                        <input type="text" name="link_title" value="Home" class="form-control" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <input type="text" name="link_url" value="#" class="form-control" placeholder="Link">
                      </div>
                      <div class="form-group">
                        <input type="checkbox" name="new_tab" value="1" class="form-control"> <span>Open in New Tab</span>
                      </div>
                      <div class="form-group"><button class="btn btn-primary" id="addLink" type="submit">Add</button></div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    @if( $selected !== '' )
                      {{ Form::open( ['url' => route('menu.store')] ) }}
                          <input type="hidden" name="step" value="{{ $param }}">
                          <input type="hidden" name="menu_name" value="{{ $selected }}">
                          <div class="dd m-container" id="nestable4">
                              <ol class="dd-list item-list">

                              <?php $data = false;                                
                                  if( old('menu') && json_decode( old('menu') ) )
                                    $data = old('menu');
                                  else if( old('menu_data') && json_decode( old('menu_data') ) )
                                    $data = old('menu_data');
                                  elseif( $menu )
                                    $data = $menu->content;

                                  $list = $data ? json_decode( $data ) : false;
                                ?>
                                    
                                @if( $list )
                                  @foreach( $list as $li )
                                    <li class="dd-item" {{ isset( $li->type ) ? 'data-type='.$li->type.'' : '' }} {{ isset( $li->url ) ? 'data-url='.$li->url.'' : '' }} {{ isset( $li->name ) ? 'data-name='.$li->name.'' : '' }} {{ isset( $li->id ) ? 'data-id='.$li->id.'' : '' }} {{ isset( $li->slug ) ? 'data-slug='.$li->slug.'' : '' }} {{ isset($li->target) ? 'data-target='.$li->target : '' }} >

                                      <div class="dd-handle"><?php 
                                        if(isset($li->slug)) 
                                          echo str_replace('-', ' ', ucfirst($li->slug));
                                        elseif(isset($li->name))
                                          echo ucfirst($li->name);
                                        ?></div>
                                        @if( isset( $li->children ) )
                                          <?php list_child_item( $li->children ); ?>
                                        @endif
                                        
                                    </li>
                                  @endforeach
                                @else
                                  <li class="dd-item" data-type="link" data-url="{{ url('/') }}" data-slug="home" data-id="0">
                                    <div class="dd-handle">Home</div>
                                  </li>
                                @endif

                              </ol>
                          </div>
                          <textarea style="display: none;" name="menu_data">{{ $data }}</textarea>
                          <textarea style="display: none;" name="menu" id="nestable-output">{{ $data }}</textarea>
                          <button type="submit" class="btn btn-primary pull-right">Submit</button>
                      {{ Form::close() }}
                    @endif
                </div>


                <div class="col-lg-3 col-md-3">
                  <label>Delete</label> <span>Drop here to remove an item from menu</span>
                  <div class="dd" id="nestable5">
                    <div class="dd-empty"></div>
                  </div>
                </div>
                <textarea style="display: none;" name="menu" id="nestable-output5"></textarea>

                </div>

                </div>

            </div>
              
          </div>
          <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      <!-- /.row -->



<script type="text/javascript" src="{{ asset('assets/admin/js/jquery.nestable.js') }}"></script>
    <script>

$(document).ready(function()
{

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this work.');
        }
    };

    // activate Nestable for list 1
    /*$('#nestable').nestable({
        group: 1
    })
    .on('change', updateOutput);*/

    $('#nestable2').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable3').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable4').nestable({
        group: 1
    })
    .on('change', updateOutput);

    $('#nestable5').nestable({
        group: 1
    })
    .on('change', updateOutput);

    // activate Nestable for list 2
    // $('#nestable2').nestable({
    //     group: 1
    // })
    // .on('change', updateOutput);

    // output initial serialised data
    /*updateOutput($('#nestable').data('output', $('#output')));*/
    updateOutput($('#nestable2').data('output', $('#nestable-output')));
    updateOutput($('#nestable3').data('output', $('#nestable-output')));
    updateOutput($('#nestable4').data('output', $('#nestable-output')));
    updateOutput($('#nestable5').data('output', $('#nestable-output5')));
    // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

    $('#nestable-menu').on('click', function(e)
    {
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

    // $('#nestable3').nestable();

});
</script>


@endsection