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
