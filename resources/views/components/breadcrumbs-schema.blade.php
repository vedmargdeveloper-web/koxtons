@props(['breadcrumbItems' => []])

@if(count($breadcrumbItems))
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": @json(App\Services\BreadcrumbsService::generate($breadcrumbItems))
}
</script>
@endif