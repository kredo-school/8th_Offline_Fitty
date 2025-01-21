<!-- Modal -->
<div class="modal fade" id="memoModal" tabindex="-1" aria-labelledby="memoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #FFA965; color: white;">
        <h5 class="modal-title" id="memoModalLabel" >Edit Memo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="memoForm" action="{{ route('nutri.updateMemo', $user_profile->id) }}" method="POST">
          @csrf
          <textarea class="form-control" id="memoText" name="memo" rows="5" placeholder="Add memo...">{{ old('memo', $user_profile->nutritionist_memo) }}</textarea>
          @error('memo')
            <div class="text-danger mt-2">{{ $message }}</div>
          @enderror
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn" style="background-color: #202F55; color: white;" data-bs-dismiss="modal">Close</button>
      <button type="submit" form="memoForm" class="btn" style="background-color: #FFA965; color: white;">Save</button>
      </div>
    </div>
  </div>
</div>
