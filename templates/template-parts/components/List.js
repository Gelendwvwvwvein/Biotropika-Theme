export default function List({ items = [] }) {
  return (
    <ul className="biotropika-list">
      {items.map((item, i) => <li key={i}>{item}</li>)}
    </ul>
  );
}
