<div class="row">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-content">
                <div class="tab_left">
                    <ul  class="nav nav-tabs nav-red">
                        @foreach($tabs as $tab)
                            {!! Shortcode::compile($tab['li']) !!}
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($tabs as $tab)
                            <div class='{!! isset($tab['tab']['active']) ? 'active' : '' !!} tab-pane fade in'
                                 id='{!! $tab['tab']['id'] !!}'>
                                <div class="row column-seperation">
                                    @foreach($tab['tab']['form'] as $input)
                                        <div class="form-group">
                                            {!! Shortcode::compile($input) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>