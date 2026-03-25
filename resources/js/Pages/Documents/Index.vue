<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  documents: Object,
  filters: Object,
  kategoriList: Array,
  stats: Object,
})

const page = usePage()
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin')

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
  router.get(route('documents.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

/*
|--------------------------------------------------------------------------
| Modal cabut SOP
|--------------------------------------------------------------------------
*/
const showRevokeModal = ref(false)
const selectedRevokeId = ref(null)
const revokedReason = ref('')

const openRevokeModal = (id) => {
  selectedRevokeId.value = id
  revokedReason.value = ''
  showRevokeModal.value = true
}

const closeRevokeModal = () => {
  showRevokeModal.value = false
  selectedRevokeId.value = null
  revokedReason.value = ''
}

const submitRevoke = () => {
  if (!revokedReason.value.trim()) {
    alert('Alasan pencabutan wajib diisi.')
    return
  }

  router.patch(route('documents.revoke', selectedRevokeId.value), {
    revoked_reason: revokedReason.value,
  }, {
    preserveScroll: true,
    onSuccess: () => closeRevokeModal(),
  })
}

/*
|--------------------------------------------------------------------------
| Modal hapus
|--------------------------------------------------------------------------
*/
const showDeleteModal = ref(false)
const selectedDeleteId = ref(null)

const openDeleteModal = (id) => {
  selectedDeleteId.value = id
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  selectedDeleteId.value = null
}

const submitDelete = () => {
  router.delete(route('documents.destroy', selectedDeleteId.value), {
    preserveScroll: true,
    onSuccess: () => closeDeleteModal(),
  })
}
</script>

<template>
  <Head title="Dokumen Portal SOP" />

  <AuthenticatedLayout>
    <template #header>
      <div class="rounded-3xl bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 p-6 shadow-sm">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
          <div class="text-white">
            <p class="text-sm font-medium text-white/80">
              PT Agrofarm Nusa Raya
            </p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight">
              Dokumen Portal SOP
            </h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/85">
              Sistem terpusat untuk mengelola dokumen aktif, memudahkan pencarian SOP,
              serta mendukung distribusi dokumen lintas departemen secara sistematis dan profesional.
            </p>
          </div>

          <div class="flex flex-wrap gap-2">
            <Link
              :href="route('dashboard')"
              class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50"
            >
              📊 Dashboard
            </Link>

            <Link
              v-if="isAdmin"
              :href="route('documents.create')"
              class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/15"
            >
              ➕ Tambah Dokumen
            </Link>
          </div>
        </div>
      </div>
    </template>

    <div class="min-h-screen bg-slate-100">
      <div class="mx-auto max-w-7xl space-y-6 px-6 py-6">
        <!-- FILTER -->
        <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
          <div class="mb-5">
            <h3 class="text-xl font-bold text-slate-900">Filter Dokumen</h3>
            <p class="mt-1 text-sm text-slate-500">
              Cari berdasarkan nomor dokumen, judul, atau departemen.
            </p>
          </div>

          <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
            <div class="xl:col-span-5">
              <input
                v-model="q"
                type="text"
                placeholder="Cari nomor atau judul dokumen..."
                class="w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                @keyup.enter="submitFilter"
              />
            </div>

            <div class="xl:col-span-4">
              <select
                v-model="kategori"
                class="w-full rounded-2xl border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
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

            <div class="flex flex-wrap gap-3 xl:col-span-3 xl:justify-end">
              <button
                type="button"
                @click="submitFilter"
                class="rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
              >
                Cari
              </button>

              <button
                type="button"
                @click="resetFilter"
                class="rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200"
              >
                Reset
              </button>

              <Link
                v-if="isAdmin"
                :href="route('documents.create')"
                class="rounded-2xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
              >
                + Tambah
              </Link>
            </div>
          </div>
        </section>

        <!-- TABLE -->
        <section class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
          <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <h3 class="text-xl font-bold text-slate-900">Daftar Dokumen Aktif</h3>
                <p class="mt-1 text-sm text-slate-500">
                  <template v-if="documents.total > 0">
                    Menampilkan {{ documents.from }}–{{ documents.to }} dari {{ documents.total }} dokumen
                  </template>
                  <template v-else>
                    Tidak ada dokumen ditemukan
                  </template>
                </p>
              </div>

              <div class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">
                Status: Active
              </div>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-slate-50 text-slate-600">
                <tr>
                  <th class="px-6 py-4 font-semibold">No</th>
                  <th class="px-6 py-4 font-semibold">Nomor Dokumen</th>
                  <th class="px-6 py-4 font-semibold">Judul</th>
                  <th class="px-6 py-4 font-semibold">Departemen</th>
                  <th class="px-6 py-4 font-semibold">Status</th>
                  <th class="px-6 py-4 font-semibold">Aksi</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100 bg-white">
                <tr v-if="!documents.data.length">
                  <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                    <div class="space-y-2">
                      <div class="text-4xl">📂</div>
                      <div class="font-semibold text-slate-700">Belum ada dokumen</div>
                      <div class="text-sm">Coba ubah kata kunci atau filter departemen.</div>
                    </div>
                  </td>
                </tr>

                <tr
                  v-for="(doc, i) in documents.data"
                  :key="doc.id"
                  class="transition hover:bg-slate-50"
                >
                  <td class="px-6 py-4 text-slate-700">
                    {{ documents.from + i }}
                  </td>

                  <td class="px-6 py-4">
                    <div class="font-semibold text-slate-900">
                      {{ doc.nomor_dokumen }}
                    </div>
                  </td>

                  <td class="px-6 py-4 text-slate-800">
                    {{ doc.judul }}
                  </td>

                  <td class="px-6 py-4">
                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-blue-700">
                      {{ doc.kategori || '-' }}
                    </span>
                  </td>

                  <td class="px-6 py-4">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">
                      Active
                    </span>
                  </td>

                  <td class="px-6 py-4">
                    <div class="flex flex-wrap items-center gap-2">
                      <a
                        :href="route('documents.open', doc.id)"
                        target="_blank"
                        class="rounded-xl bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100"
                      >
                        Buka
                      </a>

                      <Link
                        v-if="isAdmin"
                        :href="route('documents.edit', doc.id)"
                        class="rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                      >
                        Edit
                      </Link>

                      <button
                        v-if="isAdmin"
                        type="button"
                        @click="openDeleteModal(doc.id)"
                        class="rounded-xl bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                      >
                        Hapus
                      </button>

                      <button
                        v-if="isAdmin"
                        type="button"
                        @click="openRevokeModal(doc.id)"
                        class="rounded-xl bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-100"
                      >
                        Cabut
                      </button>

                      <span
                        v-if="!isAdmin"
                        class="text-xs italic text-slate-400"
                      >
                        Read only
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- PAGINATION -->
          <div
            v-if="documents.links?.length"
            class="border-t border-slate-200 px-6 py-4"
          >
            <div class="flex flex-wrap gap-2">
              <button
                v-for="(link, index) in documents.links"
                :key="index"
                v-html="link.label"
                :disabled="!link.url"
                @click="link.url && router.visit(link.url)"
                class="rounded-xl px-4 py-2 text-sm font-medium transition"
                :class="[
                  link.active
                    ? 'bg-emerald-600 text-white'
                    : 'bg-slate-100 text-slate-700 hover:bg-slate-200',
                  !link.url ? 'cursor-not-allowed opacity-50' : ''
                ]"
                type="button"
              />
            </div>
          </div>
        </section>


      </div>
    </div>

    <!-- MODAL CABUT SOP -->
    <div
      v-if="showRevokeModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
      <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-slate-900">
          Cabut SOP
        </h3>

        <p class="mt-2 text-sm text-slate-500">
          Masukkan alasan pencabutan dokumen. Dokumen akan dipindahkan ke histori SOP dicabut.
        </p>

        <textarea
          v-model="revokedReason"
          rows="4"
          class="mt-4 w-full rounded-2xl border-slate-300 text-sm focus:border-red-500 focus:ring-red-500"
          placeholder="Contoh: SOP sudah diganti dengan versi terbaru..."
        ></textarea>

        <div class="mt-6 flex justify-end gap-3">
          <button
            type="button"
            @click="closeRevokeModal"
            class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200"
          >
            Batal
          </button>

          <button
            type="button"
            @click="submitRevoke"
            class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
          >
            Cabut SOP
          </button>
        </div>
      </div>
    </div>

    <!-- MODAL HAPUS -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >
      <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
        <h3 class="text-xl font-bold text-slate-900">
          Hapus Dokumen
        </h3>

        <p class="mt-2 text-sm text-slate-500">
          Dokumen akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="mt-6 flex justify-end gap-3">
          <button
            type="button"
            @click="closeDeleteModal"
            class="rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200"
          >
            Batal
          </button>

          <button
            type="button"
            @click="submitDelete"
            class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
          >
            Hapus
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
