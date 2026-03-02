<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  nomor_dokumen: '',
  judul: '',
  kategori: '',
  deskripsi: '',
  file_url: '',
})

const submit = () => {
  form.post(route('documents.store'))
}
</script>

<template>
  <Head title="Tambah Dokumen SOP" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Tambah Dokumen SOP</h2>
        <Link class="text-sm text-green-700 hover:underline" :href="route('documents.index')">
          Kembali
        </Link>
      </div>
    </template>

    <div class="py-6">
      <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 space-y-4">
            <div>
              <label class="text-sm text-gray-600">Nomor Dokumen</label>
              <input v-model="form.nomor_dokumen" class="mt-1 w-full rounded-lg border-gray-300" />
              <div v-if="form.errors.nomor_dokumen" class="mt-1 text-sm text-red-600">
                {{ form.errors.nomor_dokumen }}
              </div>
            </div>

            <div>
              <label class="text-sm text-gray-600">Judul</label>
              <input v-model="form.judul" class="mt-1 w-full rounded-lg border-gray-300" />
              <div v-if="form.errors.judul" class="mt-1 text-sm text-red-600">
                {{ form.errors.judul }}
              </div>
            </div>

            <div>
              <label class="text-sm text-gray-600">Kategori</label>
              <input v-model="form.kategori" class="mt-1 w-full rounded-lg border-gray-300" />
            </div>

            <div>
              <label class="text-sm text-gray-600">Deskripsi</label>
              <textarea v-model="form.deskripsi" rows="3" class="mt-1 w-full rounded-lg border-gray-300" />
            </div>

            <div>
              <label class="text-sm text-gray-600">Link (Drive/URL)</label>
              <input v-model="form.file_url" class="mt-1 w-full rounded-lg border-gray-300" placeholder="https://..." />
              <div v-if="form.errors.file_url" class="mt-1 text-sm text-red-600">
                {{ form.errors.file_url }}
              </div>
            </div>

            <div class="pt-2">
              <button
                @click="submit"
                :disabled="form.processing"
                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 disabled:opacity-50"
              >
                Simpan
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
