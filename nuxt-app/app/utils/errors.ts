export function getApiErrorMessage(e: unknown, fallback = "Something went wrong. Please try again."): string {
  if (typeof e === "object" && e !== null) {
    const err = e as Record<string, any>;
    const msg = err?.response?.data?.message;
    if (msg) return msg;

    const errors: Record<string, string[]> = err?.response?.data?.errors ?? {};
    const firstField = Object.values(errors)[0];
    if (firstField?.length) return firstField[0]!;
  }
  return fallback;
}
