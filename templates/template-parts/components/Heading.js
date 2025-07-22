export default function Heading({ level = 2, children, ...props }) {
  // Гарантируем диапазон 1–6
  const Tag = `h${Math.min(6, Math.max(1, level))}`;
  return <Tag {...props}>{children}</Tag>;
}
