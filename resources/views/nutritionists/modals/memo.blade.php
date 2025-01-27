<!-- モーダルのHTMLコード -->
<div class="modal fade" id="memoModal" tabindex="-1" aria-labelledby="memoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #FFA965; color: white;">
                <h5 class="modal-title" id="memoModalLabel">Edit Memo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="memoForm" action="{{ route('nutri.updateMemo', $user_profile->id) }}" method="POST">
                    @csrf
                    <textarea class="form-control" id="memoText" name="memo" rows="5"
                        placeholder="Add memo...">{{ old('memo', $user_profile->nutritionist_memo) }}</textarea>
                    @error('memo')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: #202F55; color: white;"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveMemoButton" class="btn" data-bs-dismiss="modal" aria-label="Close" style="background-color: #FFA965; color: white;">Save</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- モーダルに関するスクリプト -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const saveMemoButton = document.getElementById('saveMemoButton');
        const memoForm = document.getElementById('memoForm');
        const memoText = document.getElementById('memoText');
        const memoContainer = document.querySelector('.memo-container');

        if (saveMemoButton && memoForm) {
            saveMemoButton.addEventListener('click', (e) => {
                e.preventDefault();

                const memoData = new FormData(memoForm);

                memoData.append('_method', 'POST'); // 必要に応じて変更

                fetch(memoForm.action, {
                    method: 'POST',
                   // headers: {
                   //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                   // },
                   headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                       'Accept': 'application/json',
                   },
                  body: memoData
                })

                .then(response => {

                    if (!response.ok) {
                        return response.json().then(data => {
                            // サーバーからのエラー詳細を含めて例外をスロー
                            throw new Error(data.message || 'Failed to save memo');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    //alert('Memo saved successfully!');
                    memoContainer.innerHTML = memoText.value.replace(/\n/g, '<br>');

                    const modalElement = document.getElementById('memoModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide(); // モーダルを閉じる
                    }



                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to save memo.');
                });
            });
        }
    });
</script>
