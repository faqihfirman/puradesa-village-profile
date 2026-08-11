import { Head, useForm, usePage } from '@inertiajs/react';
import { Clock, MapPin, Phone, Send } from 'lucide-react';
import { useState } from 'react';
import { FacebookIcon, InstagramIcon, YoutubeIcon } from '@/Components/SocialIcons';
import PublicLayout from '@/Layouts/PublicLayout';
import type { SharedProps } from '@/types';

type ContactForm = {
  name: string;
  email: string;
  message: string;
  website: string;
  rendered_at: number;
};

export default function Contact() {
  const { village, flash } = usePage<SharedProps>().props;
  const { contact } = village;
  const [renderedAt] = useState(() => Date.now());

  const { data, setData, post, processing, errors, reset } = useForm<ContactForm>({
    name: '',
    email: '',
    message: '',
    website: '',
    rendered_at: renderedAt,
  });

  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    post('/kontak', {
      preserveScroll: true,
      onSuccess: () => reset('name', 'email', 'message'),
    });
  };

  const mapEmbedSrc = `https://www.google.com/maps?q=${encodeURIComponent(contact.address)}&output=embed`;

  return (
    <PublicLayout>
      <Head title="Kontak" />

      <div className="bg-background-alt py-section-mobile md:py-section-desktop">
        <div className="mx-auto max-w-container px-4 md:px-6">
          <h1 className="font-display text-3xl font-bold text-ink md:text-5xl">Hubungi Kami</h1>
          <p className="mt-4 max-w-2xl text-body">
            Pemerintah {village.name} selalu siap melayani. Silakan hubungi kami untuk informasi lebih lanjut mengenai
            layanan desa, perizinan, atau jika Anda memiliki saran dan masukan untuk kemajuan desa kita.
          </p>

          <div className="mt-10 grid gap-6 lg:grid-cols-5">
            <div className="relative min-h-[500px] overflow-hidden rounded-card lg:col-span-3">
              <iframe
                title="Peta lokasi kantor desa"
                src={mapEmbedSrc}
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                className="absolute inset-0 h-full w-full border-0"
              />

              <div className="absolute inset-x-4 bottom-4 rounded-card bg-surface/95 p-5 shadow-lg backdrop-blur">
                <div className="flex items-start gap-3">
                  <span className="mt-0.5 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-primary text-on-primary">
                    <MapPin className="h-4 w-4" />
                  </span>
                  <div>
                    <h3 className="font-display text-base font-semibold text-ink">{village.officeName}</h3>
                    <p className="mt-1 text-sm text-body">{contact.address}</p>
                    <a
                      href={contact.mapsUrl}
                      target="_blank"
                      rel="noreferrer"
                      className="mt-2 inline-flex items-center gap-1 font-display text-sm font-semibold text-primary hover:text-primary-hover"
                    >
                      Dapatkan Petunjuk Arah →
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <div className="rounded-card border border-border bg-surface p-6 lg:col-span-2 md:p-8">
              <div className="flex items-start gap-3">
                <span className="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-primary text-on-primary">
                  <Clock className="h-5 w-5" />
                </span>
                <div>
                  <h3 className="font-display text-sm font-semibold text-ink">Jam Operasional</h3>
                  <p className="mt-1 text-sm text-body">{contact.hours.weekday}</p>
                  <p className="text-sm text-body">{contact.hours.weekend}</p>
                </div>
              </div>

              <div className="mt-5 flex items-start gap-3">
                <span className="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-primary text-on-primary">
                  <Phone className="h-5 w-5" />
                </span>
                <div>
                  <h3 className="font-display text-sm font-semibold text-ink">Telepon &amp; Email</h3>
                  <a href={`tel:${contact.phone}`} className="mt-1 block text-sm text-body hover:text-primary">
                    {contact.phone}
                  </a>
                  <a href={`mailto:${contact.email}`} className="block text-sm text-body hover:text-primary">
                    {contact.email}
                  </a>
                </div>
              </div>

              <div className="mt-5">
                <h3 className="font-display text-sm font-semibold text-ink">Media Sosial</h3>
                <div className="mt-2 flex gap-2">
                  {contact.social.facebook && (
                    <a
                      href={contact.social.facebook}
                      target="_blank"
                      rel="noreferrer"
                      aria-label="Facebook"
                      className="flex h-9 w-9 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
                    >
                      <FacebookIcon className="h-4 w-4" />
                    </a>
                  )}
                  {contact.social.instagram && (
                    <a
                      href={contact.social.instagram}
                      target="_blank"
                      rel="noreferrer"
                      aria-label="Instagram"
                      className="flex h-9 w-9 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
                    >
                      <InstagramIcon className="h-4 w-4" />
                    </a>
                  )}
                  {contact.social.youtube && (
                    <a
                      href={contact.social.youtube}
                      target="_blank"
                      rel="noreferrer"
                      aria-label="YouTube"
                      className="flex h-9 w-9 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
                    >
                      <YoutubeIcon className="h-4 w-4" />
                    </a>
                  )}
                </div>
              </div>

              <hr className="my-6 border-border" />

              <h2 className="font-display text-xl font-semibold text-ink">Kirim Pesan</h2>

              {flash.success && (
                <div className="mt-4 rounded-button bg-secondary-container px-4 py-3 text-sm text-on-secondary-container">
                  {flash.success}
                </div>
              )}

              <form onSubmit={submit} className="mt-4 space-y-4" noValidate>
                <div className="hidden" aria-hidden="true">
                  <label htmlFor="website">Jangan diisi</label>
                  <input
                    type="text"
                    id="website"
                    name="website"
                    tabIndex={-1}
                    autoComplete="off"
                    value={data.website}
                    onChange={(e) => setData('website', e.target.value)}
                  />
                </div>

                <div>
                  <label htmlFor="name" className="font-display text-sm font-semibold text-ink">
                    Nama Lengkap
                  </label>
                  <input
                    id="name"
                    type="text"
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                    placeholder="Masukkan nama Anda"
                    aria-describedby={errors.name ? 'name-error' : undefined}
                    className="mt-1.5 w-full rounded-input border border-border bg-background px-4 py-2.5 text-sm text-ink placeholder:text-muted focus:border-primary focus:outline-none"
                  />
                  {errors.name && (
                    <p id="name-error" className="mt-1 text-xs text-accent">
                      {errors.name}
                    </p>
                  )}
                </div>

                <div>
                  <label htmlFor="email" className="font-display text-sm font-semibold text-ink">
                    Alamat Email
                  </label>
                  <input
                    id="email"
                    type="email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    placeholder="nama@email.com"
                    aria-describedby={errors.email ? 'email-error' : undefined}
                    className="mt-1.5 w-full rounded-input border border-border bg-background px-4 py-2.5 text-sm text-ink placeholder:text-muted focus:border-primary focus:outline-none"
                  />
                  {errors.email && (
                    <p id="email-error" className="mt-1 text-xs text-accent">
                      {errors.email}
                    </p>
                  )}
                </div>

                <div>
                  <label htmlFor="message" className="font-display text-sm font-semibold text-ink">
                    Pesan
                  </label>
                  <textarea
                    id="message"
                    rows={4}
                    value={data.message}
                    onChange={(e) => setData('message', e.target.value)}
                    placeholder="Tulis pesan atau pertanyaan Anda di sini..."
                    aria-describedby={errors.message ? 'message-error' : undefined}
                    className="mt-1.5 w-full rounded-input border border-border bg-background px-4 py-2.5 text-sm text-ink placeholder:text-muted focus:border-primary focus:outline-none"
                  />
                  {errors.message && (
                    <p id="message-error" className="mt-1 text-xs text-accent">
                      {errors.message}
                    </p>
                  )}
                </div>

                <button
                  type="submit"
                  disabled={processing}
                  className="flex w-full items-center justify-center gap-2 rounded-button bg-primary px-6 py-3 font-display text-sm font-semibold text-on-primary transition-colors hover:bg-primary-hover disabled:cursor-not-allowed disabled:opacity-60"
                >
                  {processing ? (
                    'Mengirim...'
                  ) : (
                    <>
                      Kirim Pesan Sekarang <Send className="h-4 w-4" />
                    </>
                  )}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </PublicLayout>
  );
}
