export interface Media {
  id: number;
  uuid: string;
  collection_name: string;
  name: string;
  file_name: string;
  mime_type?: string;
  disk: string;
  size: number;
  original_url: string;
  preview_url?: string;
}
enum MediaCollection {
  image = "image",
  audio = "audio",
  video = "video",
}
export interface UploadData {
  file: File;
  collection: MediaCollection;
  //            'file' => ['required', 'file', 'max:10240'],
  //            'collection' => ['required', 'in:image,audio,video'],
}
