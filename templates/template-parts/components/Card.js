export default function Card({ children, className = '', ...props }) {
  return (
    <div className={`biotropika-card ${className}`} {...props}>
      {children}
    </div>
  );
}
