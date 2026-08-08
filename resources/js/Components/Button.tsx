import { Link } from '@inertiajs/react';
import type { ButtonHTMLAttributes, MouseEventHandler, ReactNode } from 'react';

type Variant = 'primary' | 'secondary' | 'accent';

const variantClasses: Record<Variant, string> = {
  primary: 'bg-primary text-on-primary hover:bg-primary-hover',
  secondary: 'border-2 border-secondary text-primary bg-transparent hover:bg-secondary-container',
  accent: 'bg-accent text-on-accent hover:bg-accent-hover',
};

const baseClasses =
  'inline-flex items-center justify-center rounded-button px-6 py-3 font-display text-sm font-semibold transition-colors';

type ButtonProps = {
  variant?: Variant;
  children: ReactNode;
  className?: string;
  href?: string;
  onClick?: MouseEventHandler;
  type?: ButtonHTMLAttributes<HTMLButtonElement>['type'];
};

export default function Button({ variant = 'primary', className = '', children, href, onClick, type }: ButtonProps) {
  const classes = `${baseClasses} ${variantClasses[variant]} ${className}`;

  if (href) {
    return (
      <Link href={href} className={classes} onClick={onClick}>
        {children}
      </Link>
    );
  }

  return (
    <button type={type ?? 'button'} className={classes} onClick={onClick}>
      {children}
    </button>
  );
}
