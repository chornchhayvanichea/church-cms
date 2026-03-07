import type {
  EditorToolbarItem,
  EditorMentionMenuItem,
  EditorSuggestionMenuItem,
  EditorCustomHandlers,
} from "@nuxt/ui";
import type { Editor } from "@tiptap/vue-3";

export const useBlogEditorConfig = () => {
  // image toolbar

  const customHandlers = {
    imageUpload: {
      canExecute: (editor: Editor) =>
        editor.can().insertContent({ type: "imageUpload" }),
      execute: (editor: Editor) =>
        editor.chain().focus().insertContent({ type: "imageUpload" }),
      isActive: (editor: Editor) => editor.isActive("imageUpload"),
      isDisabled: undefined,
    },
  } satisfies EditorCustomHandlers;

  const toolBarItems: EditorToolbarItem[][] = [
    // History controls
    [
      {
        kind: "undo",
        icon: "i-lucide-undo",
        tooltip: { text: "Undo" },
      },
      {
        kind: "redo",
        icon: "i-lucide-redo",
        tooltip: { text: "Redo" },
      },
    ],
    // Block types
    [
      {
        icon: "i-lucide-heading",
        tooltip: { text: "Headings" },
        content: {
          align: "start",
        },
        items: [
          {
            kind: "heading",
            level: 1,
            icon: "i-lucide-heading-1",
            label: "Heading 1",
          },
          {
            kind: "heading",
            level: 2,
            icon: "i-lucide-heading-2",
            label: "Heading 2",
          },
          {
            kind: "heading",
            level: 3,
            icon: "i-lucide-heading-3",
            label: "Heading 3",
          },
          {
            kind: "heading",
            level: 4,
            icon: "i-lucide-heading-4",
            label: "Heading 4",
          },
        ],
      },
      {
        icon: "i-lucide-list",
        tooltip: { text: "Lists" },
        content: {
          align: "start",
        },
        items: [
          {
            kind: "bulletList",
            icon: "i-lucide-list",
            label: "Bullet List",
          },
          {
            kind: "orderedList",
            icon: "i-lucide-list-ordered",
            label: "Ordered List",
          },
        ],
      },
      {
        kind: "blockquote",
        icon: "i-lucide-text-quote",
        tooltip: { text: "Blockquote" },
      },
      {
        kind: "codeBlock",
        icon: "i-lucide-square-code",
        tooltip: { text: "Code Block" },
      },
      {
        kind: "horizontalRule",
        icon: "i-lucide-separator-horizontal",
        tooltip: { text: "Horizontal Rule" },
      },
    ],
    //image
    [
      {
        kind: "imageUpload",
        icon: "i-lucide-image",
        label: "Add image",
        variant: "soft",
      },
    ],
    // Text formatting
    [
      {
        kind: "mark",
        mark: "bold",
        icon: "i-lucide-bold",
        tooltip: { text: "Bold" },
      },
      {
        kind: "mark",
        mark: "italic",
        icon: "i-lucide-italic",
        tooltip: { text: "Italic" },
      },
      {
        kind: "mark",
        mark: "underline",
        icon: "i-lucide-underline",
        tooltip: { text: "Underline" },
      },
      {
        kind: "mark",
        mark: "strike",
        icon: "i-lucide-strikethrough",
        tooltip: { text: "Strikethrough" },
      },
      {
        kind: "mark",
        mark: "code",
        icon: "i-lucide-code",
        tooltip: { text: "Code" },
      },
    ],
    // Link
    [
      {
        kind: "link",
        icon: "i-lucide-link",
        tooltip: { text: "Link" },
      },
    ],
    // Text alignment
    [
      {
        icon: "i-lucide-align-justify",
        tooltip: { text: "Text Align" },
        content: {
          align: "end",
        },
        items: [
          {
            kind: "textAlign",
            align: "left",
            icon: "i-lucide-align-left",
            label: "Align Left",
          },
          {
            kind: "textAlign",
            align: "center",
            icon: "i-lucide-align-center",
            label: "Align Center",
          },
          {
            kind: "textAlign",
            align: "right",
            icon: "i-lucide-align-right",
            label: "Align Right",
          },
          {
            kind: "textAlign",
            align: "justify",
            icon: "i-lucide-align-justify",
            label: "Align Justify",
          },
        ],
      },
    ],
  ];

  const items: EditorToolbarItem[][] = [
    [
      {
        icon: "i-lucide-heading",
        tooltip: { text: "Headings" },
        content: {
          align: "start",
        },
        items: [
          {
            kind: "heading",
            level: 1,
            icon: "i-lucide-heading-1",
            label: "Heading 1",
          },
          {
            kind: "heading",
            level: 2,
            icon: "i-lucide-heading-2",
            label: "Heading 2",
          },
          {
            kind: "heading",
            level: 3,
            icon: "i-lucide-heading-3",
            label: "Heading 3",
          },
          {
            kind: "heading",
            level: 4,
            icon: "i-lucide-heading-4",
            label: "Heading 4",
          },
        ],
      },
    ],
    [
      {
        kind: "mark",
        mark: "bold",
        icon: "i-lucide-bold",
        tooltip: { text: "Bold" },
      },
      {
        kind: "mark",
        mark: "italic",
        icon: "i-lucide-italic",
        tooltip: { text: "Italic" },
      },
      {
        kind: "mark",
        mark: "underline",
        icon: "i-lucide-underline",
        tooltip: { text: "Underline" },
      },
      {
        kind: "mark",
        mark: "strike",
        icon: "i-lucide-strikethrough",
        tooltip: { text: "Strikethrough" },
      },
      {
        kind: "mark",
        mark: "code",
        icon: "i-lucide-code",
        tooltip: { text: "Code" },
      },
    ],
  ];
  const SuggestionItems: EditorSuggestionMenuItem[][] = [
    [
      {
        type: "label",
        label: "Text",
      },
      {
        kind: "paragraph",
        label: "Paragraph",
        icon: "i-lucide-type",
      },
      {
        kind: "heading",
        level: 1,
        label: "Heading 1",
        icon: "i-lucide-heading-1",
      },
      {
        kind: "heading",
        level: 2,
        label: "Heading 2",
        icon: "i-lucide-heading-2",
      },
      {
        kind: "heading",
        level: 3,
        label: "Heading 3",
        icon: "i-lucide-heading-3",
      },
    ],
    [
      {
        type: "label",
        label: "Lists",
      },
      {
        kind: "bulletList",
        label: "Bullet List",
        icon: "i-lucide-list",
      },
      {
        kind: "orderedList",
        label: "Numbered List",
        icon: "i-lucide-list-ordered",
      },
    ],
    [
      {
        type: "label",
        label: "Insert",
      },
      {
        kind: "blockquote",
        label: "Blockquote",
        icon: "i-lucide-text-quote",
      },
      {
        kind: "codeBlock",
        label: "Code Block",
        icon: "i-lucide-square-code",
      },
      {
        kind: "horizontalRule",
        label: "Divider",
        icon: "i-lucide-separator-horizontal",
      },
    ],
  ];

  const MentionItems: EditorMentionMenuItem[] = [
    {
      label: "benjamincanac",
      avatar: {
        src: "https://avatars.githubusercontent.com/u/739984?v=4",
      },
    },
    {
      label: "atinux",
      avatar: {
        src: "https://avatars.githubusercontent.com/u/904724?v=4",
      },
    },
    {
      label: "danielroe",
      avatar: {
        src: "https://avatars.githubusercontent.com/u/28706372?v=4",
      },
    },
    {
      label: "pi0",
      avatar: {
        src: "https://avatars.githubusercontent.com/u/5158436?v=4",
      },
    },
  ];
  return {
    toolBarItems,
    items,
    SuggestionItems,
    MentionItems,
    customHandlers,
  };
};
