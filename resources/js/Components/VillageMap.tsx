export default function VillageMap({ lat, lng, zoom, className = '' }: { lat: number; lng: number; zoom: number; className?: string }) {
  const src = `https://www.google.com/maps?q=${lat},${lng}&z=${zoom}&output=embed`;

  return (
    <div className={`overflow-hidden rounded-card border border-border bg-surface-dim ${className}`}>
      <iframe
        src={src}
        title="Peta Kantor Desa Puraseda"
        loading="lazy"
        className="h-full w-full"
        style={{ border: 0, minHeight: 280 }}
        allowFullScreen
      />
    </div>
  );
}
