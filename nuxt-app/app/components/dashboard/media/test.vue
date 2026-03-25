<template>
  <div>
    <ul>
      <li v-for="track in tracks" :key="track.id">
        <button type="button" @click="onPlayAsPlaylist(tracks, track)">
          {{ isTrackPlaying(track.id) ? "Pause" : "Play" }}
        </button>
        {{ track.title }}
      </li>
    </ul>
  </div>
  <MusicFlow
    :options="{
      autoplay: true,
    }"
  />
</template>

<script setup lang="ts">
import type { TMusicFlow } from "vue-music-flow";
const { onPlayAsPlaylist, isTrackPlaying } = useMusicFlow();

const tracks: TMusicFlow[] = [
  {
    id: 1,
    audio:
      "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/dreamy-slow.mp3",
    title: "Sample Audio 1#",
    artist: "John Walkers",
    artwork: "https://placehold.co/512x512",
    album: "Free Audio",
    original: {
      source:
        "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/dreamy-slow.mp3",
    },
  },
  {
    id: 2,
    audio:
      "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/dreamy-slow.mp3",
    title: "Sample Audio 2#",
    artist: "Steve Rooney",
    artwork: "https://placehold.co/512x512",
    album: "Free Audio",
    original: {
      source:
        "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/",
    },
  },
  {
    id: 3,
    audio:
      "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/dreamy-slow.mp3",
    title: "Sample Audio 3#",
    artist: "Julie Rock",
    artwork: "https://placehold.co/512x512",
    album: "Free Audio",
    original: {
      source:
        "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/",
    },
  },
  {
    id: 4,
    audio:
      "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/dreamy-slow.mp3",
    title: "Sample Audio 4#",
    artist: "Hans Broom",
    artwork: "https://placehold.co/512x512",
    album: "Free Audio",
    original: {
      source:
        "https://ik.imagekit.io/ltdassets/public/audio/edm/all-world-music/",
    },
  },
];
</script>
