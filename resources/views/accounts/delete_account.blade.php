@extends('baselayout.common_page_base')

@section ('content')

  @extends('baselayout.common_navigation')

<div class="content p-t-6">
  <div class="content__padded">
    <div class="profile_content">
      <h3 class="title_profile">Are you sure you want to delete your account</h3>
      {{-- {!! Form::open(['method' => 'POST' , 'id'=>'form-delete-account', 'class'=>'input-group', 'url'=> URL::to('/', array(), false) ]) !!} --}}

      <div class="delete-form">
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="never_take" name="include" value="yes">
          <label class="checkbox__styled__label" for="never_take">I’ll never take Risk Reduction Score.</label>
        </div>
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="not_useful" name="include" value="yes">
          <label class="checkbox__styled__label" for="not_useful">I don't find Brain Health useful</label>
        </div>
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="privacy_concern" name="include" value="yes">
          <label class="checkbox__styled__label" for="privacy_concern">I have a privacy concern</label>
        </div>
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="flood_mails" name="include" value="yes">
          <label class="checkbox__styled__label" for="flood_mails">I'm getting too much email from Brainsalvation</label>
        </div>
        <div class="checkbox__styled p0 mt15">
          <input type="checkbox" class="checkbox__styled__input" id="suffering_disease" name="include" value="yes">
          <label class="checkbox__styled__label" for="suffering_disease">I'm suffering from a particular disease</label>
        </div>
        <div class="checkbox__styled p0 mt15 ">
          <input type="checkbox" class="checkbox__styled__input" id="others" name="include" value="yes">
          <label class="checkbox__styled__label" for="others">Other. Please explain further.</label>
          <textarea name="reason" class="form-control m-t-2 m-b-3 textarea-h120"></textarea>
        </div>
        <hr class="m-t-0 m-b-2">
        <div class="check__score">
          <button id="delete-account-btn" class="btn btn__regular dis-block-xs" data-toggle="modal" data-target="#modal-confirm">Delete My Account</button>
          <button id="cancel-btn" class="btn btn__regular dis-block-xs" type="submit">Cancel</button>
        </div>
      </div>
    {{-- {!! Form::close() !!} --}}
  </div>
</div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade modal-confirm-delete" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-y-3 p-x-3">
        <h3 class="m-b-3">Are you sure that you want to Delete your account, contacts and personal information completely?</h3>
        <div class="text-center">
          <button id="delete-account-btn" class="btn btn__regular btn-warning">Delete My Account</button>
          <button id="cancel-btn" class="btn btn__regular" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>

@stop
