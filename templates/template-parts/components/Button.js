export default function Button({ children, href, ...props }) {
  return <a className="biotropika-btn" href={href} {...props}>{children}</a>;
}
