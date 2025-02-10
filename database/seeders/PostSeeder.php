<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        /* RECETAS DE PAQUI */
        $post1 = Post::create([
            'title' => 'Pastel de Chocolate',
            'description' => 'Un delicioso pastel de chocolate con cobertura de ganache.',
            'ingredients' => 'Harina, Azúcar, Cacao en polvo, Huevos, Leche, Mantequilla',
            'image' => 'images/pastel.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds1 = Category::whereIn('name', ['Pasteles'])->pluck('id');
        $post1->categories()->attach($categoryIds1);

        $tagPost1 = Tag::firstOrCreate(['name' => '#Chocolate #Pastel #Ganache #Postre #Delicioso #Fácil #Esponjoso']);
        $post1->tags()->attach($tagPost1->id);

        $post2 = Post::create([
            'title' => 'Tarta de Fresas',
            'description' => 'Tarta con base de galleta y fresas frescas.',
            'ingredients' => 'Galletas, Mantequilla, Fresas, Crema Pastelera',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds2 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post2->categories()->attach($categoryIds2);

        $tagPost2 = Tag::firstOrCreate(['name' => '#Fresas #Tarta #Galletas #Cremapastelera #Verano #Postre #Sencillo']);
        $post2->tags()->attach($tagPost2->id);

        $post3 = Post::create([
            'title' => 'Tarta de Manzana',
            'description' => 'Tarta tradicional de manzana con una base crujiente y relleno jugoso, ideal para el té.',
            'ingredients' => 'Manzanas, Masa quebrada, Azúcar, Canela, Mantequilla, Huevo, Limón',
            'image' => 'images/pastel.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds3 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post3->categories()->attach($categoryIds3);

        $tagPost3 = Tag::firstOrCreate(['name' => '#Postre #Fruta #Fácil #Tradicional']);
        $post3->tags()->attach($tagPost3->id);

        $post4 = Post::create([
            'title' => 'Brownie de Chocolate',
            'description' => 'Un pastel denso y húmedo con un sabor intenso a chocolate.',
            'ingredients' => 'Chocolate, Mantequilla, Azúcar, Harina, Huevos, Nueces (opcional)',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 1,
        ]);
        $categoryIds4 = Category::whereIn('name', ['Brownie'])->pluck('id');
        $post4->categories()->attach($categoryIds4);

        $tagPost4 = Tag::firstOrCreate(['name' => '#Chocolate #Húmedo #Postre #Fácil']);
        $post4->tags()->attach($tagPost4->id);

        $post5 = Post::create([
            'title' => 'Cupcakes de Vainilla',
            'description' => 'Pequeños bizcochos esponjosos con un suave sabor a vainilla, perfectos para decorar.',
            'ingredients' => 'Harina, Azúcar, Mantequilla, Huevo, Esencia de vainilla, Polvo de hornear, Leche',
            'image' => 'images/pastel.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds5 = Category::whereIn('name', ['Cupcakes'])->pluck('id');
        $post5->categories()->attach($categoryIds5);

        $tagPost5 = Tag::firstOrCreate(['name' => '#Vainilla #Suave #Postre #Fiesta']);
        $post5->tags()->attach($tagPost5->id);

        $post6 = Post::create([
            'title' => 'Galletas de Avena y Pasas',
            'description' => 'Galletas crujientes con avena y pasas, una combinación saludable y deliciosa.',
            'ingredients' => 'Avena, Pasas, Harina, Mantequilla, Azúcar moreno, Huevo, Polvo de hornear',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds6 = Category::whereIn('name', ['Galletas'])->pluck('id');
        $post6->categories()->attach($categoryIds6);

        $tagPost6 = Tag::firstOrCreate(['name' => '#Saludable #Avena #Dulce #Fácil']);
        $post6->tags()->attach($tagPost6->id);

        $post7 = Post::create([
            'title' => 'Pastel de Zanahoria',
            'description' => 'Un pastel húmedo y esponjoso con zanahorias, nueces y cubierto con un glaseado de queso crema.',
            'ingredients' => 'Zanahorias, Harina, Azúcar, Nueces, Huevo, Aceite, Especias, Queso crema',
            'image' => 'images/pastel.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds7 = Category::whereIn('name', ['Pasteles'])->pluck('id');
        $post7->categories()->attach($categoryIds7);

        $tagPost7 = Tag::firstOrCreate(['name' => '#Saludable #Especias #Dulce #Fácil']);
        $post7->tags()->attach($tagPost7->id);

        $post8 = Post::create([
            'title' => 'Tarta de Limón y Merengue',
            'description' => 'Tarta refrescante con una base de masa quebrada, relleno de crema de limón y merengue suave.',
            'ingredients' => 'Limón, Masa quebrada, Azúcar, Huevo, Maicena, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 1,
        ]);
        $categoryIds8 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post8->categories()->attach($categoryIds8);

        $tagPost8 = Tag::firstOrCreate(['name' => '#Cítrico #Merengue #Refrescante #Postre']);
        $post8->tags()->attach($tagPost8->id);

        $post9 = Post::create([
            'title' => 'Pudin de Chía y Cacao',
            'description' => 'Un postre saludable y fácil de hacer, ideal para las tardes de verano.',
            'ingredients' => 'Semillas de chía, Cacao en polvo, Leche de almendra, Miel',
            'image' => 'images/pastel.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds9 = Category::whereIn('name', ['Postres saludables'])->pluck('id');
        $post9->categories()->attach($categoryIds9);

        $tagPost9 = Tag::firstOrCreate(['name' => '#Saludable #Vegano #Cacao #Rápido']);
        $post9->tags()->attach($tagPost9->id);

        $post10 = Post::create([
            'title' => 'Madeleines Francesas',
            'description' => 'Pequeños bizcochos esponjosos con una forma característica de concha, muy típicos de la repostería francesa.',
            'ingredients' => 'Harina, Mantequilla, Muevo, Azúcar, Polvo de hornear, Esencia de vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 1,
        ]);
        $categoryIds10 = Category::whereIn('name', ['Bizcochos'])->pluck('id');
        $post10->categories()->attach($categoryIds10);

        $tagPost10 = Tag::firstOrCreate(['name' => '#Francesa #Esponjoso #Té #Tradicional']);
        $post10->tags()->attach($tagPost10->id);

        $post11 = Post::create([
            'title' => 'Galletas de Chocolate Chips',
            'description' => 'Galletas crujientes por fuera y suaves por dentro, con chips de chocolate.',
            'ingredients' => 'Harina, Azúcar, Mantequilla, Chocolate, Huevo, Polvo de hornear',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 1,
        ]);
        $categoryIds11 = Category::whereIn('name', ['Galletas'])->pluck('id');
        $post11->categories()->attach($categoryIds11);

        $tagPost11 = Tag::firstOrCreate(['name' => '#Chocolate #Rápido #Crujiente #Postre']);
        $post11->tags()->attach($tagPost11->id);

        $post12 = Post::create([
            'title' => 'Cheesecake de Fresa',
            'description' => 'Tarta de queso cremoso con una capa de fresas frescas o mermelada, ideal para los amantes del queso.',
            'ingredients' => 'Queso crema, Galletas, Mantequilla, Azúcar, Fresas, Nata',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 1,
        ]);
        $categoryIds12 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post12->categories()->attach($categoryIds12);

        $tagPost12 = Tag::firstOrCreate(['name' => '#Queso #Fresa #Cremoso #Postre']);
        $post12->tags()->attach($tagPost12->id);

        $post13 = Post::create([
            'title' => 'Pancakes Americanos',
            'description' => 'Tortitas gruesas y esponjosas, perfectas para desayunar o merendar.',
            'ingredients' => 'Harina, Huevo, Leche, Azúcar, Levadura, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 1,
        ]);
        $categoryIds13 = Category::whereIn('name', ['Desayunos, Postres Sin Horno'])->pluck('id');
        $post13->categories()->attach($categoryIds13);

        $tagPost13 = Tag::firstOrCreate(['name' => '#Esponjoso #Fácil #Desayuno #Tradicional']);
        $post13->tags()->attach($tagPost13->id);

        $post14 = Post::create([
            'title' => 'Tarta de Chocolate y Avellanas',
            'description' => 'Una combinación perfecta de chocolate y avellanas en una deliciosa tarta.',
            'ingredients' => 'Chocolate, Avellanas, Mantequilla, Azúcar, Huevo, Crema',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 1,
        ]);
        $categoryIds14 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post14->categories()->attach($categoryIds14);

        $tagPost14 = Tag::firstOrCreate(['name' => '#Chocolate #Avellanas #Postre #Rico']);
        $post14->tags()->attach($tagPost14->id);

        $post15 = Post::create([
            'title' => 'Roscón de Reyes',
            'description' => 'Un pan dulce tradicional de España que se sirve durante las festividades de Reyes.',
            'ingredients' => 'Harina, Azúcar, Levadura, Huevo, Naranja, Agua de azahar, Fruta escarchada',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 1,
        ]);
        $categoryIds15 = Category::whereIn('name', ['Panes'])->pluck('id');
        $post15->categories()->attach($categoryIds15);

        $tagPost15 = Tag::firstOrCreate(['name' => '#Tradicional #Navidad #Festivo #Dulce']);
        $post15->tags()->attach($tagPost15->id);


        /* RECETAS DE ANTONIO */
        $post16 = Post::create([
            'title' => 'Bizcocho de Yogur',
            'description' => 'Bizcocho fácil de hacer con la receta del yogurt como medida.',
            'ingredients' => 'Yogur natural, Azúcar, Huevo, Harina, Aceite, Levadura',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 2,
        ]);
        $categoryIds16 = Category::whereIn('name', ['Bizcochos'])->pluck('id');
        $post16->categories()->attach($categoryIds16);

        $tagPost16 = Tag::firstOrCreate(['name' => '#Fácil #Esponjoso #Básico #Dulce']);
        $post16->tags()->attach($tagPost16->id);

        $post17 = Post::create([
            'title' => 'Tarta de Queso al Horno',
            'description' => 'Deliciosa tarta de queso con una base crujiente y un relleno cremoso.',
            'ingredients' => 'Queso crema, Huevos, Azúcar, Galletas, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 2,
        ]);
        $categoryIds17 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post17->categories()->attach($categoryIds17);

        $tagPost17 = Tag::firstOrCreate(['name' => '#Queso #Horneado #Cremoso #Postre']);
        $post17->tags()->attach($tagPost17->id);

        $post18 = Post::create([
            'title' => 'Cupcakes de Arándanos',
            'description' => 'Cupcakes esponjosos con arándanos frescos que explotan de sabor en cada bocado.',
            'ingredients' => 'Harina, Azúcar, Arándanos, Leche, Huevo, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 2,
        ]);
        $categoryIds18 = Category::whereIn('name', ['Cupcakes'])->pluck('id');
        $post18->categories()->attach($categoryIds18);

        $tagPost18 = Tag::firstOrCreate(['name' => '#Fruta #Esponjoso #Fácil #Desayuno']);
        $post18->tags()->attach($tagPost18->id);

        $post19 = Post::create([
            'title' => 'Tarta de Chocolate Blanco y Frambuesas',
            'description' => 'Una tarta elegante con chocolate blanco y frambuesas frescas.',
            'ingredients' => 'Chocolate blanco, Frambuesas, Galletas, Mantequilla, Nata',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 2,
        ]);
        $categoryIds19 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post19->categories()->attach($categoryIds19);

        $tagPost19 = Tag::firstOrCreate(['name' => '#Chocolate blanco #Frambuesa #Elegante #Postre']);
        $post19->tags()->attach($tagPost19->id);

        $post20 = Post::create([
            'title' => 'Pastelitos de Naranja y Almendra',
            'description' => 'Pastelitos aromáticos con un toque de naranja y almendra, perfectos para cualquier ocasión.',
            'ingredients' => 'Almendra molida, Naranja, Harina, Azúcar, Huevo, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 2,
        ]);
        $categoryIds20 = Category::whereIn('name', ['Pasteles'])->pluck('id');
        $post20->categories()->attach($categoryIds20);

        $tagPost20 = Tag::firstOrCreate(['name' => '#Naranja #Almendra #Aromático #Dulce']);
        $post20->tags()->attach($tagPost20->id);

        $post21 = Post::create([
            'title' => 'Bizcocho de Plátano',
            'description' => 'Un bizcocho húmedo y delicioso que aprovecha los plátanos maduros.',
            'ingredients' => 'Plátanos, Azúcar, Huevo, Harina, Mantequilla, Levadura',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 2,
        ]);
        $categoryIds21 = Category::whereIn('name', ['Bizcochos'])->pluck('id');
        $post21->categories()->attach($categoryIds21);

        $tagPost21 = Tag::firstOrCreate(['name' => '#Plátano #Húmedo #Fácil #Postre']);
        $post21->tags()->attach($tagPost21->id);

        $post22 = Post::create([
            'title' => 'Galletas de Mantequilla',
            'description' => 'Galletas clásicas de mantequilla con un sabor suave y textura crujiente.',
            'ingredients' => 'Mantequilla, Azúcar, Harina, Huevo, Esencia de vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 2,
        ]);
        $categoryIds22 = Category::whereIn('name', ['Galletas'])->pluck('id');
        $post22->categories()->attach($categoryIds22);

        $tagPost22 = Tag::firstOrCreate(['name' => '#Mantequilla #Clásicas #Fácil #Dulce']);
        $post22->tags()->attach($tagPost22->id);

        $post23 = Post::create([
            'title' => 'Churros Caseros',
            'description' => 'Deliciosos churros crujientes por fuera y suaves por dentro, perfectos para acompañar con chocolate.',
            'ingredients' => 'Harina, Agua, Azúcar, Sal, Aceite',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 2,
        ]);
        $categoryIds23 = Category::whereIn('name', ['Desayunos, Postres fritos'])->pluck('id');
        $post23->categories()->attach($categoryIds23);

        $tagPost23 = Tag::firstOrCreate(['name' => '#Frito #Tradicional #Dulce #Caliente']);
        $post23->tags()->attach($tagPost23->id);

        $post24 = Post::create([
            'title' => 'Tarta de Coco y Piña',
            'description' => 'Tarta tropical con una mezcla dulce de coco y piña.',
            'ingredients' => 'Coco rallado, Piña, Azúcar, Harina, Huevo, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 2,
        ]);
        $categoryIds24 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post24->categories()->attach($categoryIds24);

        $tagPost24 = Tag::firstOrCreate(['name' => '#Tropical #Coco #Piña #Postre']);
        $post24->tags()->attach($tagPost24->id);

        $post25 = Post::create([
            'title' => 'Bizcocho de Café',
            'description' => 'Bizcocho con un toque de café que lo convierte en el acompañante perfecto para el desayuno.',
            'ingredients' => 'Café, Harina, Azúcar, Huevo, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 2,
        ]);
        $categoryIds25 = Category::whereIn('name', ['Bizcochos'])->pluck('id');
        $post25->categories()->attach($categoryIds25);

        $tagPost25 = Tag::firstOrCreate(['name' => '#Café #Energético #Dulce #Desayuno']);
        $post25->tags()->attach($tagPost25->id);


        /* RECETAS DE MARIA */
        $post26 = Post::create([
            'title' => 'Tiramisu',
            'description' => 'Postre italiano con capas de bizcocho empapado en café y mascarpone cremoso.',
            'ingredients' => 'Mascarpone, Café, Bizcochos de soletilla, Cacao en polvo, Azúcar, Huevo',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds26 = Category::whereIn('name', ['Postres, Reposteria Internacional'])->pluck('id');
        $post26->categories()->attach($categoryIds26);

        $tagPost26 = Tag::firstOrCreate(['name' => '#Italiano #Café #Cremoso #Dulce']);
        $post26->tags()->attach($tagPost26->id);

        $post27 = Post::create([
            'title' => 'Barras de Granola Caseras',
            'description' => 'Deliciosas barras de granola crujiente y saludable, perfectas para un snack rápido.',
            'ingredients' => 'Avena, Frutos secos, Miel, Azúcar, Mantequilla, Chocolate (opcional)',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds27 = Category::whereIn('name', ['Postres saludables'])->pluck('id');
        $post27->categories()->attach($categoryIds27);

        $tagPost27 = Tag::firstOrCreate(['name' => '#Saludable #Snack #Crujiente #Fácil']);
        $post27->tags()->attach($tagPost27->id);

        $post28 = Post::create([
            'title' => 'Tarta de Pera y Almendra',
            'description' => 'Una combinación perfecta de peras jugosas y almendras en una base crujiente.',
            'ingredients' => 'Peras, Almendra molida, Azúcar, Huevo, Mantequilla, Masa quebrada',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'private',
            'user_id' => 3,
        ]);
        $categoryIds28 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post28->categories()->attach($categoryIds28);

        $tagPost28 = Tag::firstOrCreate(['name' => '#Pera #Almendra #Deliciosa #Postre']);
        $post28->tags()->attach($tagPost28->id);

        $post29 = Post::create([
            'title' => 'Galletas de Limón y Jengibre',
            'description' => 'Galletas con un toque cítrico de limón y el sabor picante del jengibre.',
            'ingredients' => 'Limón, Jengibre, Azúcar, Mantequilla, Harina, Huevo',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds29 = Category::whereIn('name', ['Galletas'])->pluck('id');
        $post19->categories()->attach($categoryIds29);

        $tagPost29 = Tag::firstOrCreate(['name' => '#Limón #Jengibre #Cítrico #Dulce']);
        $post29->tags()->attach($tagPost29->id);

        $post30 = Post::create([
            'title' => 'Tarta Sacher',
            'description' => 'Un clásico austriaco de chocolate con un toque de mermelada de albaricoque.',
            'ingredients' => 'Chocolate, Mantequilla, Azúcar, Harina, Mermelada de albaricoque',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 3,
        ]);
        $categoryIds30 = Category::whereIn('name', ['Tartas, Reposteria Internacional'])->pluck('id');
        $post30->categories()->attach($categoryIds30);

        $tagPost30 = Tag::firstOrCreate(['name' => '#Chocolate #Clásica #Aventura #Mermelada']);
        $post30->tags()->attach($tagPost30->id);

        $post31 = Post::create([
            'title' => 'Mousse de Chocolate',
            'description' => 'Un postre ligero y esponjoso con un intenso sabor a chocolate.',
            'ingredients' => 'Chocolate, Nata, Azúcar, Huevo, Vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds31 = Category::whereIn('name', ['Postres'])->pluck('id');
        $post31->categories()->attach($categoryIds31);

        $tagPost31 = Tag::firstOrCreate(['name' => '#Chocolate #Cremoso #Ligero #Rápido']);
        $post31->tags()->attach($tagPost31->id);

        $post32 = Post::create([
            'title' => 'Tarta de Frutas',
            'description' => 'Una tarta fresca con frutas variadas y una base de masa quebrada.',
            'ingredients' => 'Frutas frescas, Masa quebrada, Crema pastelera, Azúcar',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 3,
        ]);
        $categoryIds32 = Category::whereIn('name', ['Tartas'])->pluck('id');
        $post32->categories()->attach($categoryIds32);

        $tagPost32 = Tag::firstOrCreate(['name' => '#Fruta #Fresco #Ligero #Dulce']);
        $post32->tags()->attach($tagPost32->id);

        $post33 = Post::create([
            'title' => 'Eclairs de Chocolate',
            'description' => 'Deliciosos profiteroles alargados rellenos de crema pastelera y cubiertos con chocolate.',
            'ingredients' => 'Harina, Huevos, Mantequilla, Leche, Azúcar, Chocolate, Crema pastelera',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds33 = Category::whereIn('name', ['Repostería Internacional'])->pluck('id');
        $post33->categories()->attach($categoryIds33);

        $tagPost33 = Tag::firstOrCreate(['name' => '#Eclairs #Chocolate #Pastelería #Cremapastelera #Dulce']);
        $post33->tags()->attach($tagPost33->id);

        $post34 = Post::create([
            'title' => 'Donas Glaseadas',
            'description' => 'Clásicas donas esponjosas fritas y cubiertas con un glaseado dulce.',
            'ingredients' => 'Harina, Azúcar, Levadura, Leche, Huevos, Mantequilla, Esencia de vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 3,
        ]);
        $categoryIds34 = Category::whereIn('name', ['Postres Fritos'])->pluck('id');
        $post34->categories()->attach($categoryIds34);

        $tagPost34 = Tag::firstOrCreate(['name' => '#Donas #Glaseado #Esponjoso #Casero #Dulce']);
        $post34->tags()->attach($tagPost34->id);


        /* RECETAS DE DAVID */
        $post35 = Post::create([
            'title' => 'Macarons de Frambuesa',
            'description' => 'Galletas francesas de almendra con relleno cremoso de frambuesa.',
            'ingredients' => 'Harina de almendra, Azúcar glas, Claras de huevo, Frambuesas, Chocolate blanco',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 4,
        ]);
        $categoryIds35 = Category::whereIn('name', ['Repostería Internacional'])->pluck('id');
        $post35->categories()->attach($categoryIds35);

        $tagPost35 = Tag::firstOrCreate(['name' => '#Macarons #Frambuesa #Pastelería #Delicado #Colorido']);
        $post35->tags()->attach($tagPost35->id);

        $post36 = Post::create([
            'title' => 'Chocotorta Argentina',
            'description' => 'Postre argentino sin horno hecho con capas de galletas de chocolate y crema de dulce de leche.',
            'ingredients' => 'Galletas de chocolate, Dulce de leche, Queso crema, Café',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 4,
        ]);
        $categoryIds36 = Category::whereIn('name', ['Postres Sin Horno, Repostería Internacional'])->pluck('id');
        $post36->categories()->attach($categoryIds36);

        $tagPost36 = Tag::firstOrCreate(['name' => '#Chocotorta #Sinhorno #Argentino #Dulcedeleche #Fácil']);
        $post36->tags()->attach($tagPost36->id);

        $post37 = Post::create([
            'title' => 'Flan de Caramelo',
            'description' => 'Postre clásico con una textura suave y cubierto con caramelo líquido.',
            'ingredients' => 'Huevos, Leche, Azúcar, Esencia de vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'shared',
            'user_id' => 4,
        ]);
        $categoryIds37 = Category::whereIn('name', ['Postres'])->pluck('id');
        $post37->categories()->attach($categoryIds37);

        $tagPost37 = Tag::firstOrCreate(['name' => '#Flan #Caramelo #Suave #Tradicional #Casero']);
        $post37->tags()->attach($tagPost37->id);

        $post38 = Post::create([
            'title' => 'Baklava de Pistacho',
            'description' => 'Dulce típico del Medio Oriente hecho con capas de masa filo, miel y pistachos.',
            'ingredients' => 'Masa filo, Pistachos, Miel, Azúcar, Mantequilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 4,
        ]);
        $categoryIds38 = Category::whereIn('name', ['Repostería Internacional'])->pluck('id');
        $post38->categories()->attach($categoryIds38);

        $tagPost38 = Tag::firstOrCreate(['name' => '#Baklava #Pistacho #Dulceoriental #Crujiente #Casero']);
        $post38->tags()->attach($tagPost38->id);

        $post39 = Post::create([
            'title' => 'Helado Casero de Vainilla',
            'description' => 'Cremoso y delicioso helado casero con un intenso sabor a vainilla.',
            'ingredients' => 'Leche, Nata, Azúcar, Yemas de huevo, Esencia de vainilla',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 4,
        ]);
        $categoryIds39 = Category::whereIn('name', ['Helado, Postres Fríos'])->pluck('id');
        $post39->categories()->attach($categoryIds39);

        $tagPost39 = Tag::firstOrCreate(['name' => '#Helado #Vainilla #Casero #Fácil #Refrescante']);
        $post39->tags()->attach($tagPost39->id);

        $post40 = Post::create([
            'title' => 'Panettone Italiano',
            'description' => 'Pan dulce esponjoso con frutas confitadas y pasas, tradicional en Navidad.',
            'ingredients' => 'Harina, Levadura, Azúcar, Mantequilla, Huevo, Pasas, Frutas confitadas',
            'image' => 'images/tarta-fresas.png',
            'visibility' => 'public',
            'user_id' => 4,
        ]);
        $categoryIds40 = Category::whereIn('name', ['Panes Dulces, Reposteria Internacional'])->pluck('id');
        $post40->categories()->attach($categoryIds40);

        $tagPost40 = Tag::firstOrCreate(['name' => '#Panettone #Italiano #Navideño #Esponjoso #Dulce']);
        $post40->tags()->attach($tagPost40->id);
    }
}
