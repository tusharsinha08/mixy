<template>
  <div v-if="formData" class="p-6 space-y-6">
    <h1 class="text-3xl font-bold">About Us Settings</h1>

    <!-- Hero Section -->
    <div class="p-4 bg-white rounded shadow" v-if="formData.hero">
      <h2 class="mb-2 text-xl font-semibold">Hero Section</h2>
      <input v-model="formData.hero.title" placeholder="Hero Title" class="w-full p-2 mb-2 border rounded" />
      <input v-model="formData.hero.subtitle" placeholder="Hero Subtitle" class="w-full p-2 mb-2 border rounded" />
      <input v-model="formData.hero.buttonText" placeholder="Button Text" class="w-full p-2 border rounded" />
    </div>

    <!-- Who We Are -->
    <div class="p-4 bg-white rounded shadow" v-if="formData.whoWeAre">
      <h2 class="mb-2 text-xl font-semibold">Who We Are</h2>
      <textarea v-model="formData.whoWeAre.text" placeholder="Describe who you are"
        class="w-full p-2 border rounded"></textarea>
    </div>

    <!-- Our Values -->
    <div class="p-4 bg-white rounded shadow" v-if="formData.ourValues">
      <h2 class="mb-2 text-xl font-semibold">Our Values</h2>
      <textarea v-model="formData.ourValues.text" placeholder="Values" class="w-full p-2 border rounded"></textarea>
    </div>

    <!-- Our Mission -->
    <div class="p-4 bg-white rounded shadow" v-if="formData.ourMission">
      <h2 class="mb-2 text-xl font-semibold">Our Mission</h2>
      <textarea v-model="formData.ourMission.text" placeholder="Mission" class="w-full p-2 border rounded"></textarea>
    </div>

    <!-- Fun Facts -->
    <section class="bg-white shadow rounded-xl p-6">
      <h2 class="text-xl font-semibold mb-4">Fun Facts</h2>

      <div v-for="(fact, index) in formData.funFacts" :key="index" class="flex space-x-4 mb-3 items-center">
        <input v-model="fact.icon" type="text" placeholder="Icon (e.g. ❤️)" class="border rounded p-2 w-20" />
        <input v-model="fact.count" type="number" placeholder="Count" class="border rounded p-2 w-28" />
        <input v-model="fact.label" type="text" placeholder="Label" class="border rounded p-2 flex-1" />
        <button type="button" @click="removeFunFact(index)" class="text-red-500 font-bold px-2 py-1">
          ✖
        </button>
      </div>

      <div class="flex space-x-2 mt-4">
        <button type="button" @click="addFunFact" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          + Add Fact
        </button>
        <button @click="saveFunFacts" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          Save Fun Facts
        </button>
      </div>
    </section>

    <!-- Team Members -->
    <div class="p-4 bg-white rounded shadow" v-if="formData.teamMembers">
      <h2 class="mb-4 text-xl font-semibold">Team Members</h2>

      <div v-for="(member, index) in formData.teamMembers" :key="member.id || index" class="relative p-4 mb-4 space-y-3 border rounded">
        <button @click="removeTeamMember(index)" class="absolute top-2 right-2 text-red-600 hover:text-red-800 text-lg" title="Remove Member">
          ✕
        </button>
         <div class="flex items-center gap-2 mb-3">
                <h3 class="font-medium text-gray-900">Member {{ index + 1 }}</h3>
              </div>

        <div>
          <h2 class="font-bold mb-1">Name</h2>
          <input v-model="member.name" placeholder="Name" class="w-full p-2 border rounded" />
        </div>

        <div>
          <h2 class="font-bold mb-1">Designation</h2>
          <input v-model="member.role" placeholder="Role" class="w-full p-2 border rounded" />
        </div>

        <div>
          <h2 class="font-bold mb-1">Image</h2>
          <input type="file" accept="image/*" @change="onImageUpload($event, index)" class="w-full p-2 border rounded" />
          <div v-if="member.image" class="mt-2">
            <img :src="member.image" alt="Preview" class="object-cover w-24 h-24 rounded-full border" />
          </div>
        </div>
      </div>

      <div class="flex space-x-2">
        <button @click="addTeamMember" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
          + Add Member
        </button>
        <button @click="saveTeamMembers" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
          Save Team Members
        </button>
      </div>
    </div>

    <!-- Save Button -->
    <div class="pt-4 border-t">
      <button @click="saveAboutUs" class="px-6 py-2 text-white bg-green-600 rounded hover:bg-green-700">
        Save All
      </button>
    </div>
  </div>

  <div v-else class="p-6 text-center text-gray-500">Loading...</div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  aboutUs: {
    type: Object,
    default: () => ({
      hero: { title: '', subtitle: '', buttonText: '' },
      whoWeAre: { text: '' },
      ourValues: { text: '' },
      ourMission: { text: '' },
      funFacts: [],
      teamMembers: []
    })
  }
})

const formData = ref({
  hero: props.aboutUs?.hero || { title: '', subtitle: '', buttonText: '' },
  whoWeAre: props.aboutUs?.whoWeAre || { text: '' },
  ourValues: props.aboutUs?.ourValues || { text: '' },
  ourMission: props.aboutUs?.ourMission || { text: '' },
  funFacts: props.aboutUs?.funFacts || [],
  teamMembers: props.aboutUs?.teamMembers || []
})

// Blink effect
const triggerBlink = () => {
  const body = document.body;
  body.style.transition = 'background-color 0.2s';
  body.style.backgroundColor = '#dbeafe';
  setTimeout(() => {
    body.style.backgroundColor = '';
    setTimeout(() => body.style.transition = '', 200);
  }, 200);
}

const addFunFact = () => {
  formData.value.funFacts.push({ icon: '', count: 0, label: '' })
}

const removeFunFact = (index) => {
  formData.value.funFacts.splice(index, 1)
}

const saveAboutUs = () => {
  router.post('/admin/about-us', formData.value, {
    onSuccess: () => {
      triggerBlink();
      alert('About Us updated successfully!');
    }
  })
}

const saveFunFacts = () => {
  router.post('/admin/about-us/fun-facts', { funFacts: formData.value.funFacts }, {
    onSuccess: () => {
      triggerBlink();
      alert('Fun Facts updated successfully!');
    }
  })
}

const saveTeamMembers = () => {
  router.post('/admin/about-us/team-members', { teamMembers: formData.value.teamMembers }, {
    onSuccess: () => {
      triggerBlink();
      alert('Team Members updated successfully!');
    }
  })
}

const addTeamMember = () => {
  formData.value.teamMembers.push({
    name: '',
    role: '',
    image: ''
  })
}

const removeTeamMember = (index) => {
  formData.value.teamMembers.splice(index, 1)
}

const onImageUpload = (event, index) => {
  const file = event.target.files[0]
  if (file) {
    const reader = new FileReader()
    reader.onload = e => {
      formData.value.teamMembers[index].image = e.target.result
    }
    reader.readAsDataURL(file)
  }
}
</script>