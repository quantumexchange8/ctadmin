<div class="modal fade" id="mail_modal-{{ $record->order_id }}" tabindex="-1" role="dialog" aria-labelledby="mail_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="mail_form-{{ $record->order_id }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title add-title" id="notesMailModalTitleeLabel">Compose</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-bs-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> -->
                    <div class="compose-box">
                        <div class="compose-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4 mail-form">
                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> Type:</p>
                                        {!! Form::select('attachment_type', $get_attachment_sel, $get_attachment_sel, ['class' => 'form-select', 'id' => 'attachment_type', 'placeholder' => 'Select attachment type']) !!}
                                        <span class="text-danger error-text float-start mt-1 attachment_type_error" style="font-size: 12px"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4 mail-form">
                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg> From:</p>
                                        <input type="email" id="mail_from" name="mail_from" class="form-control" value="support@currenttech.pro">
                                        <span class="text-danger error-text float-start mt-1 mail_from_error" style="font-size: 12px"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4 mail-to">
                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> To:</p>
                                        <div class="">
                                            <input type="email" id="mail_to" name="mail_to" class="form-control" value="{{ $record->user->user_email }}">
                                            <span class="text-danger error-text float-start mt-1 mail_to_error" style="font-size: 12px"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 mail-subject">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                    Subject:</p>
                                <div class="w-100">
                                    <input type="text" id="mail_subject" name="mail_subject" class="form-control">
                                    <span class="text-danger error-text float-start mt-1 mail_subject_error" style="font-size: 12px"></span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg> Upload Attachment:</p>
                                <!-- <input type="file" class="form-control-file" id="mail_File_attachment" multiple="multiple"> -->
                                <input class="form-control file-upload-input" name="mail_attachment" type="file" id="mail_attachment">
                                <span class="text-danger error-text float-start mt-1 mail_attachment_error" style="font-size: 12px"></span>
                            </div>

                            <div class="mb-4 form-group">
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> Mail Content:</p>
                                <textarea class="form-control" id="mail_content" name="mail_content" rows="3"></textarea>
                                <span class="text-danger error-text float-start mt-1 mail_content_error" style="font-size: 12px"></span>
                            </div>

                            <input type="hidden" name="order_id" value="{{ $record->order_id }}">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn py-2" data-bs-dismiss="modal"> <i class="flaticon-delete-1"></i> Discard</a>
                    <button id="submit-button" type="submit" class="btn btn-primary py-2"> Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
