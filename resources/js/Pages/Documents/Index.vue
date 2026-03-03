<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  documents: Object,
  filters: Object,
  kategoriList: Array,
})

const q = ref(props.filters?.q || '')
const kategori = ref(props.filters?.kategori || '')

const submitFilter = () => {
  router.get(route('documents.index'), {
    q: q.value,
    kategori: kategori.value,
  }, {
    preserveState: true,
    replace: true,
  })
}

const resetFilter = () => {
  q.value = ''
  kategori.value = ''
  router.get(route('documents.index'), {}, { replace: true })
}

const page = usePage()
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin')

const hapus = (id) => {
  if (!confirm('Yakin hapus dokumen ini?')) return
  router.delete(route('documents.destroy', id))
}
</script>


<template>
  <Head title="Portal SOP" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dokumen Portal SOP</h2>

        <Link
  v-if="isAdmin"
  class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
  :href="route('documents.create')"
>
  + Tambah Dokumen
</Link>
      </div>
    </template>

    <div class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-4 flex flex-col gap-3 lg:flex-row lg:items-end">
  <div class="flex flex-col gap-2 sm:flex-row">
    <input
      v-model="q"
      type="text"
      placeholder="Cari nomor atau judul..."
      class="w-full sm:w-72 rounded-lg border-gray-300 text-sm"
      @keyup.enter="submitFilter"
    />

    <select
  v-model="kategori"
  class="w-full sm:w-48 rounded-lg border-gray-300 text-sm"
>
  <option value="">Semua Departemen</option>
  <option
    v-for="item in kategoriList"
    :key="item"
    :value="item"
  >
    {{ item }}
  </option>
</select>


  </div>

  <div class="flex gap-2">
    <button
      type="button"
      @click="submitFilter"
      class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700"
    >
      Cari
    </button>

    <button
      type="button"
      @click="resetFilter"
      class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300"
    >
      Reset
    </button>
  </div>


</div>
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6">
            <div class="mb-4 text-sm text-gray-600">
  <template v-if="documents.total > 0">
    Menampilkan
<span class="font-semibold">{{ documents.from }}</span>–
<span class="font-semibold">{{ documents.to }}</span>
dari
<span class="font-semibold">{{ documents.total }}</span> dokumen
  </template>
  <template v-else>
    Tidak ada dokumen ditemukan.
  </template>
</div>
            <div class="overflow-x-auto">
            <table class="min-w-full w-full text-left text-sm border-collapse">
                <thead class="border-b bg-white text-gray-600">
                  <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nomor Dokumen</th>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Departemen</th>
                    <th class="px-4 py-3">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <tr v-if="!documents.data.length">
  <td colspan="5" class="px-4 py-6 text-center text-gray-500">
    Belum ada dokumen.
  </td>
</tr>

                  <tr v-for="(doc, i) in documents.data" :key="doc.id" class="border-b">
                    <td class="px-4 py-3">{{ i + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ doc.nomor_dokumen }}</td>
                    <td class="px-4 py-3">{{ doc.judul }}</td>
                    <td class="px-4 py-3">{{ doc.kategori || '-' }}</td>
                    <td class="px-4 py-3">
                      <a
                        class="rounded-md bg-green-50 px-3 py-1 text-green-700 hover:bg-green-100"
                        :href="route('documents.open', doc.id)"
                        target="_blank"
                      >
                        Buka
                      </a>
                    </td>
                    <td class="px-4 py-3 space-x-2">


  <Link
    v-if="isAdmin"
    class="rounded-md bg-gray-100 px-3 py-1 text-gray-700 hover:bg-gray-200"
    :href="route('documents.edit', doc.id)"
  >
    Edit
  </Link>

  <button
  type="button"
  v-if="isAdmin"
  class="rounded-md bg-red-50 px-3 py-1 text-red-700 hover:bg-red-100"
  @click="hapus(doc.id)"
>
  Hapus
</button>
</td>
                  </tr>
                </tbody>
              </table>

              <div v-if="documents.links?.length" class="mt-4 flex flex-wrap gap-2">
  <button
    v-for="link in documents.links"
    :key="link.label"
    v-html="link.label"
    :disabled="!link.url"
    @click="link.url && router.visit(link.url)"
    class="rounded-md border px-3 py-1 text-sm"
    :class="[
      link.active
        ? 'bg-green-600 text-white border-green-600'
        : 'bg-white text-gray-700 hover:bg-gray-100',
      !link.url ? 'opacity-50 cursor-not-allowed' : ''
    ]"
    type="button"
  />
</div>

            </div>

            <p class="mt-4 text-xs text-gray-500">
              Dokumen hanya menyimpan link (Drive/URL). Tombol “Buka” akan redirect ke link tersebut.
            </p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
