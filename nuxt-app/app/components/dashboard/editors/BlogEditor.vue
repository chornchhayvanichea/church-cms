<template>
  <UEditor
    v-slot="{ editor }"
    v-model="value"
    :extensions="[
      ImageUpload,
      TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ]"
    :handlers="customHandlers"
    placeholder="Start writing your blog"
    content-type="html"
    :ui="{ base: 'p-8 sm:px-16' }"
    class="w-full min-h-21"
  >
    <UEditorToolbar
      :editor="editor"
      :items="items"
      layout="bubble"
      :should-show="
        ({ editor, view }) => {
          const { from, to } = view.state.selection;
          const hasTextSelection = from !== to;
          const isNotImage = !editor.isActive('image');
          return isNotImage && hasTextSelection;
        }
      "
    />
    <UEditorToolbar :editor="editor" :items="toolBarItems" />
    <UEditorMentionMenu
      :editor="editor"
      :items="MentionItems"
      class="sm:px-8 overflow-x-auto"
      :append-to="appendToBody"
    />
    <UEditorSuggestionMenu
      :editor="editor"
      :items="SuggestionItems"
      :append-to="appendToBody"
    />
    <UEditorToolbar
      :editor="editor"
      :items="imgToolbar(editor)"
      layout="bubble"
      :should-show="
        ({ editor, view }) => {
          return editor.isActive('image') && view.hasFocus();
        }
      "
    />

    <UEditorDragHandle :editor="editor" />
  </UEditor>
</template>

<script setup lang="ts">
import TextAlign from "@tiptap/extension-text-align";
import ImageUpload from "~/extensions/EditorImageUploadExtension";
import type { Editor } from "@tiptap/vue-3";
import type { EditorToolbarItem } from "@nuxt/ui";
const { toolBarItems, items, SuggestionItems, MentionItems, customHandlers } =
  useBlogEditorConfig();

const imgToolbar = (editor: Editor): EditorToolbarItem[][] => {
  const node = editor.state.doc.nodeAt(editor.state.selection.from);

  return [
    [
      {
        icon: "i-lucide-download",
        to: node?.attrs?.src,
        download: true,
        tooltip: { text: "Download" },
      },
    ],
    [
      {
        icon: "i-lucide-trash",
        tooltip: { text: "Delete" },
        onClick: () => {
          const { state } = editor;
          const { selection } = state;

          const pos = selection.from;
          const node = state.doc.nodeAt(pos);

          if (node && node.type.name === "image") {
            editor
              .chain()
              .focus()
              .deleteRange({ from: pos, to: pos + node.nodeSize })
              .run();
          }
        },
      },
    ],
  ];
};

const value = ref(`;sdfklsdfksad;`);

// SSR-safe function to append menus to body (avoids z-index issues in docs)
const appendToBody = false ? () => document.body : undefined;
</script>
