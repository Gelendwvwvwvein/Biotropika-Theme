export default function Image({ src, alt = '', ...props }) {
  if (!src) return null; // Не выводим ничего, если нет src
  return <img className="biotropika-image" src={src} alt={alt} {...props} />;
}
