<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">

    <div class="bg-white rounded-lg shadow-lg w-[420px] p-6">
        <h3 id="confirmTitle" class="text-lg font-semibold mb-2">
            Konfirmasi
        </h3>

        <p id="confirmMessage" class="text-sm text-gray-600 mb-4">
            Apakah Anda yakin ingin melanjutkan?
        </p>

        <form id="confirmForm" method="POST">
            @csrf

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                    Batal
                </button>

                <button id="confirmButton" type="submit"
                    class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                    Ya, Lanjutkan
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openConfirmModal({
        url,
        method = 'POST',
        title = 'Konfirmasi',
        message = 'Apakah Anda yakin?',
        confirmText = 'Ya, Lanjutkan',
        confirmClass = 'bg-red-600 hover:bg-red-700'
    }) {
        const modal = document.getElementById('confirmModal');
        const form = document.getElementById('confirmForm');

        document.getElementById('confirmTitle').innerText = title;
        document.getElementById('confirmMessage').innerText = message;
        document.getElementById('confirmButton').innerText = confirmText;

        document.getElementById('confirmButton').className =
            `px-4 py-2 text-sm text-white rounded ${confirmClass}`;

        form.action = url;

        // Bersihkan dulu method lama jika ada
        let methodInput = document.getElementById('confirmMethod');

        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.id = 'confirmMethod';
            form.appendChild(methodInput);
        }

        methodInput.value = method;

        modal.classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }
</script>
