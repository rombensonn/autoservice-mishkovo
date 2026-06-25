<?php
$data = require __DIR__ . '/config.php';

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function asset(string $path): string
{
    return e($path);
}

$site = $data['site'];
$business = $data['business'];
$canonical = rtrim($site['url'], '/') . '/';
$schema = [
    '@context' => 'https://schema.org',
    '@type' => ['AutoRepair', 'LocalBusiness'],
    'name' => $business['name'],
    'url' => $canonical,
    'image' => $canonical . ltrim($site['og_image'], '/'),
    'telephone' => array_column($business['phones'], 'display'),
    'priceRange' => '$$',
    'description' => $site['description'],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'деревня Мишково, 1',
        'addressLocality' => 'деревня Мишково',
        'addressRegion' => 'Калужская область',
        'addressCountry' => 'RU',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => $business['latitude'],
        'longitude' => $business['longitude'],
    ],
    'openingHours' => 'Mo-Su 00:00-23:59',
    'paymentAccepted' => 'Cash, Credit Card',
    'areaServed' => ['Мишково', 'Боровский район', 'Калужская область', 'Киевское шоссе'],
    'sameAs' => [$business['maps_url']],
    'hasOfferCatalog' => [
        '@type' => 'OfferCatalog',
        'name' => 'Услуги шиномонтажа',
        'itemListElement' => array_map(
            static fn (array $service): array => [
                '@type' => 'Offer',
                'name' => $service['title'],
                'description' => $service['summary'],
            ],
            $data['services']
        ),
    ],
];
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($site['title']); ?></title>
    <meta name="description" content="<?= e($site['description']); ?>">
    <meta name="keywords" content="<?= e($site['keywords']); ?>">
    <link rel="canonical" href="<?= e($canonical); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:title" content="<?= e($site['title']); ?>">
    <meta property="og:description" content="<?= e($site['description']); ?>">
    <meta property="og:url" content="<?= e($canonical); ?>">
    <meta property="og:image" content="<?= e($canonical . ltrim($site['og_image'], '/')); ?>">
    <meta name="theme-color" content="#b91c1c">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap" rel="stylesheet">
    <link rel="preload" href="./images/hero.webp" as="image">
    <link rel="stylesheet" href="./css/styles.css">
    <script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>
    </script>
</head>
<body>
<a class="skip-link" href="#services">Перейти к услугам</a>

<header class="site-header" data-header>
    <div class="container header-inner">
        <a class="brand" href="#top" aria-label="<?= e($business['name']); ?>">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" focusable="false"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 3a7 7 0 0 1 6.7 5h-3.1a4.2 4.2 0 0 0-7.2 0H5.3A7 7 0 0 1 12 5Zm0 5a2 2 0 1 1 0 4 2 2 0 0 1 0-4Zm-6.7 4h3.1a4.2 4.2 0 0 0 7.2 0h3.1A7 7 0 0 1 5.3 14Z"/></svg>
            </span>
            <span>
                <strong><?= e($business['name']); ?></strong>
                <small><?= e($business['address_short']); ?></small>
            </span>
        </a>

        <nav class="main-nav" aria-label="Основная навигация">
            <?php foreach ($data['navigation'] as $item): ?>
                <a href="<?= e($item['href']); ?>"><?= e($item['label']); ?></a>
            <?php endforeach; ?>
        </nav>

        <a class="header-phone" href="tel:<?= e($business['phone_href']); ?>" aria-label="Позвонить <?= e($business['phone_display']); ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
            <span>Позвонить</span>
        </a>
    </div>
</header>

<main id="top">
    <section class="hero" aria-labelledby="hero-title">
        <picture class="hero-media" aria-hidden="true">
            <img src="./images/hero.webp" alt="" width="1800" height="1100" fetchpriority="high">
        </picture>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="hero-copy">
                <p class="eyebrow"><?= e($business['hours']); ?> · <?= e($business['address_short']); ?></p>
                <h1 id="hero-title"><?= e($business['headline']); ?></h1>
                <p class="hero-lead"><?= e($business['subheadline']); ?></p>
                <div class="hero-actions" aria-label="Основные действия">
                    <a class="button button-primary" href="tel:<?= e($business['phone_href']); ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
                        Записаться сейчас
                    </a>
                    <a class="button button-secondary" href="<?= e($business['maps_url']); ?>" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></svg>
                        Построить маршрут
                    </a>
                </div>
                <ul class="hero-badges" aria-label="Ключевые особенности">
                    <?php foreach ($data['hero_badges'] as $badge): ?>
                        <li><?= e($badge); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <aside class="hero-showcase" aria-label="Быстрые факты о шиномонтаже">
                <img src="./images/photo-service-bay.webp" alt="Автомобиль на посту шиномонтажа" width="604" height="1280" fetchpriority="high">
                <div class="hero-ticket hero-ticket-rating">
                    <span>Рейтинг</span>
                    <strong><?= e($business['rating']); ?></strong>
                    <small><?= e($business['ratings_count']); ?></small>
                </div>
                <div class="hero-ticket hero-ticket-call">
                    <span>Звонок перед визитом</span>
                    <div class="phone-list phone-list-hero">
                        <?php foreach ($business['phones'] as $phone): ?>
                            <a href="tel:<?= e($phone['href']); ?>"><?= e($phone['display']); ?></a>
                        <?php endforeach; ?>
                    </div>
                    <small>уточнить загрузку и стоимость</small>
                </div>
                <dl class="hero-stats" aria-label="Доверительные показатели">
                    <?php foreach ($data['stats'] as $stat): ?>
                        <div>
                            <dt><?= e($stat['value']); ?></dt>
                            <dd><?= e($stat['label']); ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </aside>
        </div>
    </section>

    <section class="section services-section" id="services" aria-labelledby="services-title">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow dark">Услуги</p>
                <h2 id="services-title">Что сделаем на месте</h2>
                <p>Мы собрали основные услуги по колёсам. Цены зависят от размера, типа автомобиля и конкретной задачи — лучше позвонить, чтобы узнать точную стоимость.</p>
            </div>
            <div class="services-grid">
                <?php foreach ($data['services'] as $index => $service): ?>
                    <article class="service-card">
                        <div class="service-card-top">
                            <span class="service-number"><?= e(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <span class="service-tag"><?= e($service['tag']); ?></span>
                        </div>
                        <div class="service-card-body">
                            <h3><?= e($service['title']); ?></h3>
                            <div class="service-details">
                                <div class="service-detail">
                                    <span>Что это</span>
                                    <p><?= e($service['summary']); ?></p>
                                </div>
                                <div class="service-detail">
                                    <span>Когда нужно</span>
                                    <p><?= e($service['situations']); ?></p>
                                </div>
                                <div class="service-detail">
                                    <span>Почему здесь</span>
                                    <p><?= e($service['why']); ?></p>
                                </div>
                            </div>
                            <a class="text-link" href="tel:<?= e($business['phone_href']); ?>">Уточнить по телефону</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section wheels-order-section" id="wheels-order" aria-labelledby="wheels-order-title">
        <div class="container wheels-order-layout">
            <div class="wheels-order-media" aria-hidden="true">
                <img src="./images/service-selection.webp" alt="" width="1448" height="1086" loading="lazy">
            </div>
            <div class="wheels-order-copy">
                <p class="eyebrow">Диски на заказ</p>
                <h2 id="wheels-order-title">Доставка дисков под ваш автомобиль</h2>
                <p>Шиномонтаж оказывает услуги по доставке дисков на заказ: подберём подходящий вариант по параметрам автомобиля, согласуем сроки и привезём к визиту.</p>
                <ul class="order-points">
                    <li>Подбор по размеру, разболтовке и вылету</li>
                    <li>Согласование наличия, цены и сроков</li>
                    <li>Доставка с последующей установкой на месте</li>
                </ul>
                <div class="order-actions" aria-label="Телефоны для заказа дисков">
                    <?php foreach ($business['phones'] as $phone): ?>
                        <a class="button button-primary" href="tel:<?= e($phone['href']); ?>">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
                            <?= e($phone['display']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="section advantages-section" id="advantages" aria-labelledby="advantages-title">
        <div class="container split-layout">
            <div class="section-heading">
                <p class="eyebrow dark">Почему сюда едут</p>
                <h2 id="advantages-title">Сервис по колёсам</h2>
                <p>Мы не обещаем лишнего — специализируемся на шиномонтаже, ремонте дисков, хранении, регулировке развала‑схождения и помощи в пути.</p>
                <a class="button button-dark" href="tel:<?= e($business['phone_href']); ?>">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
                    Позвонить мастеру
                </a>
            </div>
            <div class="advantages-list">
                <?php foreach ($data['advantages'] as $advantage): ?>
                    <article class="advantage-item">
                        <span aria-hidden="true"></span>
                        <div>
                            <h3><?= e($advantage['title']); ?></h3>
                            <p><?= e($advantage['text']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section photos-section" id="photos" aria-labelledby="photos-title">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow dark">Фото</p>
                <h2 id="photos-title">Как выглядит место</h2>
            </div>
            <div class="photo-grid">
                <?php foreach ($data['photos'] as $photo): ?>
                    <figure>
                        <img src="<?= asset($photo['src']); ?>" alt="<?= e($photo['alt']); ?>" width="900" height="650">
                        <figcaption><?= e($photo['caption']); ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section reviews-section" id="reviews" aria-labelledby="reviews-title">
        <div class="container">
            <div class="reviews-head">
                <div class="section-heading">
                    <p class="eyebrow dark">Отзывы</p>
                    <h2 id="reviews-title">Что чаще всего отмечают клиенты</h2>
                </div>
                <div class="rating-block" aria-label="Рейтинг на Яндекс Картах">
                    <strong><?= e($business['rating']); ?></strong>
                    <span><?= e($business['ratings_count']); ?></span>
                    <span><?= e($business['reviews_count']); ?></span>
                </div>
            </div>
            <div class="review-grid">
                <?php foreach ($data['review_insights'] as $item): ?>
                    <article class="review-card">
                        <h3><?= e($item['title']); ?></h3>
                        <p><?= e($item['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section contacts-section" id="contacts" aria-labelledby="contacts-title">
        <div class="container contacts-layout">
            <div>
                <h2 id="contacts-title">Как нас найти</h2>
                <p class="contacts-subtitle">Шиномонтаж в Мишково</p>
                <p>Мы находимся по адресу: Калужская область, Боровский муниципальный округ, деревня Мишково, дом 1. Перед визитом позвоните, чтобы уточнить текущую загруженность, наличие нужной услуги и ориентировочную стоимость.</p>
                <div class="contact-actions">
                    <?php foreach ($business['phones'] as $phone): ?>
                        <a class="button button-primary" href="tel:<?= e($phone['href']); ?>">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
                            <?= e($phone['display']); ?>
                        </a>
                    <?php endforeach; ?>
                    <a class="button button-outline" href="<?= e($business['maps_url']); ?>" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></svg>
                        Открыть карту
                    </a>
                </div>
                <p class="checked-note"><?= e($business['checked_at']); ?></p>
            </div>
            <div class="map-panel" aria-label="Карта расположения">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=36.647605%2C55.116427&mode=search&oid=1349828158&ol=biz&z=15"
                    width="560"
                    height="420"
                    loading="lazy"
                    title="Шиномонтаж на карте Яндекса"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <section class="section faq-section" aria-labelledby="faq-title">
        <div class="container faq-layout">
            <div class="section-heading">
                <p class="eyebrow dark">FAQ</p>
                <h2 id="faq-title">Ответы на популярные вопросы</h2>
                <p>Если нужно срочно — звоните, мы поможем; а здесь собраны общие ответы</p>
            </div>
            <div class="faq-list">
                <?php foreach ($data['faq'] as $item): ?>
                    <details>
                        <summary><?= e($item['question']); ?></summary>
                        <p><?= e($item['answer']); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="final-cta" aria-labelledby="final-title">
        <div class="container final-cta-inner">
            <p class="eyebrow">24/7 · <?= e($business['address_short']); ?></p>
            <h2 id="final-title">Нужно колесо, диски или развал-схождение?</h2>
            <p>Позвоните, опишите автомобиль и задачу. Мастер подскажет, можно ли принять вас сейчас и сколько примерно займет работа.</p>
            <a class="button button-primary" href="tel:<?= e($business['phone_href']); ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
                Позвонить сейчас
            </a>
            <dl class="final-stats" aria-label="Ключевые факты">
                <div>
                    <dt><?= e($business['rating']); ?></dt>
                    <dd>рейтинг</dd>
                </div>
                <div>
                    <dt>24hr</dt>
                    <dd>каждый день</dd>
                </div>
                <div>
                    <dt>445</dt>
                    <dd>оценок</dd>
                </div>
            </dl>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-brand">
            <strong><?= e($business['name']); ?></strong>
            <p>© <?= date('Y'); ?>. <?= e($business['address_short']); ?></p>
        </div>
        <div class="footer-links" aria-label="Разделы сайта">
            <?php foreach ($data['navigation'] as $item): ?>
                <a href="<?= e($item['href']); ?>"><?= e($item['label']); ?></a>
            <?php endforeach; ?>
        </div>
        <div class="footer-contact">
            <?php foreach ($business['phones'] as $phone): ?>
                <a href="tel:<?= e($phone['href']); ?>"><?= e($phone['display']); ?></a>
            <?php endforeach; ?>
            <a href="<?= e($business['maps_url']); ?>" target="_blank" rel="noopener">Карточка на Яндекс Картах</a>
        </div>
    </div>
    <div class="container footer-slogan">Без потери времени.</div>
</footer>

<a class="sticky-call" href="tel:<?= e($business['phone_href']); ?>" aria-label="Позвонить <?= e($business['phone_display']); ?>">
    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.6 10.8c1.5 3 3.7 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.3 1.2.4 2.4.6 3.7.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.7 21 3 13.3 3 3.8c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.7.1.4 0 .8-.3 1.1l-2.2 2.2Z"/></svg>
    Позвонить
</a>

<script src="./js/main.js" defer></script>
</body>
</html>
