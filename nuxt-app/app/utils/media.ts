export const appendFileOrUrl = (
  formData: FormData,
  key: string,
  value?: File | string,
) => {
  if (value instanceof File) {
    formData.append(key, value);
  } else if (typeof value === "string") {
    formData.append(`${key}_url`, value);
  }
};
