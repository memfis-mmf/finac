<div class="modal fade" id="modal_coa" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Journal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="JournalForm">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Code @include('label::required')
                                </label>

                                @component('input::text')
                                    @slot('id', 'code')
                                    @slot('text', 'Code')
                                    @slot('name', 'code')
                                    @slot('id_error', 'code')
                                    @slot('help_text','code')
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Name @include('label::required')
                                </label>

                                @component('input::text')
                                    @slot('id', 'name')
                                    @slot('text', 'Name')
                                    @slot('name', 'name')
                                    @slot('help_text','name')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Type @include('label::required')
                                </label>

                                @component('input::select')
                                    @slot('id', 'type')
                                    @slot('text', 'Type')
                                    @slot('name', 'type')
                                    @slot('type', 'text')
                                    @slot('style', 'width:100%')
                                    @slot('help_text','type')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Description @include('label::required')
                                </label>

                                @component('input::textarea')
                                    @slot('rows', '3')
                                    @slot('id', 'description')
                                    @slot('name', 'description')
                                    @slot('text', 'Description')
                                    @slot('description', 'text')
                                    @slot('help_text','description')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                    <div class="flex">
                                        <div class="action-buttons">
                                                    @component('buttons::submit')
                                                        @slot('type', 'button')
                                                    @endcomponent

                                                    @include('buttons::reset')

                                                    @include('buttons::close')
                                            </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </form>

               </div>
            </div>
        </div>
    </div>
