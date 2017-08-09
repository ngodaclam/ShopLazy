<div class="row">
    {!! Form::open(['class' => 'form-horizontal auto-save', 'url' => isset($post['id']) ? route('post.update', $post['id']) : route('post.store')]) !!}
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> {!! trans('post::post.title') !!}
                </h4>
            </div>
            <div class="panel-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="">
                            <ul class="nav nav-tabs nav-primary">
                                @foreach($locales as $locale)
                                    <li class="{!! App::getLocale() == $locale->code ? 'active' : '' !!}">
                                        <a href="#{!! $locale->code !!}" data-toggle="tab" aria-expanded="true">
                                            {!! $locale->name !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($locales as $locale)
                                    <div class="tab-pane fade {!! App::getLocale() == $locale->code ? 'active' : '' !!} in"
                                         id="{!! $locale->code !!}">
                                        <div class="col-sm-12 form-group">
                                            <label class="control-label" for="title_{!! $locale->id !!}">{!! trans('post::post.title') !!}</label>
                                            <input type="text" class="form-control input-transparent"
                                                   id="title_{!! $locale->id !!}" name="translate[{!! $locale->id !!}][title]"
                                                   placeholder="Post Title"
                                                   value="{!! old("translate.$locale->id.title") ?: (isset($post) && $post ? $post['translate'][$locale->code]['title'] : '') !!}"/>
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            <label class="control-label" for="excerpt_{!! $locale->id !!}">{!! trans('post::post.excerpt') !!}</label>
                                            <textarea class="form-control input-transparent" id="excerpt_{!! $locale->id !!}"
                                                      name="translate[{!! $locale->id !!}][excerpt]" rows="3"
                                                    >{!! old("translate.$locale->id.excerpt") ?: (isset($post) && $post ? $post['translate'][$locale->code]['excerpt'] : '') !!}</textarea>
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            <label class="control-label" for="content_{!! $locale->id !!}">{!! trans('post::post.content') !!}</label>
                                            <textarea class="form-control input-transparent editor"
                                                      id="content_{!! $locale->id !!}"
                                                      name="translate[{!! $locale->id !!}][content]" rows="3"
                                                    >{!! old("translate.$locale->id.content") ?: (isset($post) && $post ? $post['translate'][$locale->code]['content'] : '') !!}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel">
            <div class="panel-header">
                <h4 class="panel-title">
                    <i class="fa fa-pencil"></i> {!! trans('post::post.publish') !!}
                </h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success pull-right">{!! trans('core::general.save') !!}</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="control-label" for="status">{!! trans('post::post.status') !!}</label>
                            <select class="form-control" id="status" name="status">
                                <option value="draft" {!! old('status') == 'draft' ? 'selected' : (isset($post) && $post['status'] == 'draft' ? 'selected' : '') !!}>
                                    {!! trans('post::post.draft') !!}
                                </option>
                                <option value="pending" {!! old('status') == 'pending' ? 'selected' : (isset($post) && $post['status'] == 'pending' ? 'selected' : '') !!}>
                                    {!! trans('post::post.pending') !!}
                                </option>
                                <option value="publish" {!! old('status') == 'publish' ? 'selected' : (isset($post) && $post['status'] == 'publish' ? 'selected' : '') !!}>
                                    {!! trans('post::post.publish') !!}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="control-label" for="taxonomy">{!! trans('post::post.taxonomies') !!}</label>
                            <select class="form-control" multiple id="taxonomies" name="taxonomies[]">
                                @foreach($taxonomies as $taxonomy)
                                    <option value="{!! $taxonomy['id'] !!}" {!! old('taxonomies') && in_array($taxonomy['id'], old('taxonomies')) ? 'selected' : (isset($post) && in_array($taxonomy['id'], array_pluck($post['taxonomies'], 'id')) ? 'selected' : '') !!}>
                                        {!! $taxonomy['name'] !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="control-label" for="tags">{!! trans('post::post.tags') !!}</label>
                            <input class="select-tags form-control" id="tags" name="tags"
                                   value="{!! old('tags') ? old('tags') : (isset($post) && isset($post['tags']) ? implode(',', array_pluck($post['tags'], 'name')) : '') !!}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="control-label" for="comment_status">{!! trans('post::post.comment_status') !!}</label>
                            <select class="form-control" id="comment_status" name="comment_status">
                                <option value="close" {!! old('comment_status') == 'close' ? 'selected' : (isset($post) && $post['comment_status'] == 'close' ? 'selected' : '') !!}>
                                    Close
                                </option>
                                <option value="open" {!! old('comment_status') == 'open' ? 'selected' : (isset($post) && $post['comment_status'] == 'open' ? 'selected' : '') !!}>
                                    Open
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label class="control-label" for="order">{!! trans('post::post.order') !!}</label>
                            <input type="number" class="form-control" id="order" name="order"
                                   value="{!! old('order') ?: (isset($post) && $post['order'] ?: '') !!}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="image">{!! trans('post::post.image') !!}</label>

                        <div class="col-sm-8">
                            <input type="hidden" class="form-control"
                                   id="image" name="image"
                                   value="{!! old('image') ?: (isset($post) && isset($post['image']['url']) ? $post['image']['url'] : '') !!}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="thumbnail" style="min-height: 150px;">
                                <img id="image_src"
                                     src="{!! old('image') ?: (isset($post) && isset($post['image']['url']) ? url($post['image']['url']) : '') !!}"
                                     class="img-responsive"/>
                            </div>
                            <button type="button" class="btn btn-default"
                                    onclick="ckfinder($('#image_src'), $('#image'))">{!! trans('post::post.add_image') !!}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>