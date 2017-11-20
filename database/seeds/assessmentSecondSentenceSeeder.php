<?php

use Illuminate\Database\Seeder;
use App\Eloquent\AssessmentSecondSentence;

class assessmentSecondSentenceSeeder extends Seeder
{
    protected $assessmentSecondSentence;

    public function __construct(AssessmentSecondSentence $assessmentSecondSentence)
    {
        $this->assessmentSecondSentence = $assessmentSecondSentence;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('rrs_assessment_2nd_sentence')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            '1' => array(
                'group_id' => '10',
                'category_id' => '101',
                'gif_name' => '<h5 class="topic__title topic__title--bmi"><i class="icon-score icons_bmi">&nbsp;</i>BMI </h5>',
                'second_advise' => "maintaining a healthy <b>BMI of less than 25.</b> <b style='color:red;'>( Your BMI is ",
                'reason' => 'A healthy body weight for your height is important for overall health, and for brain health, too. Obesity increases the risk for vascular disease, which is harmful to brain health.',
                'tips' => '',
                'is_active' => 1,
            ),
            '2' => array(
                'group_id' => '10',
                'category_id' => '102',
                'gif_name' => '<h5 class="topic__title topic__title--physical"><i class="icon-score icons_physical">&nbsp;</i>Physical </h5>',
                'second_advise' => 'getting at least <b>30 minutes of exercise,</b> at least <b>5 days per week.</b>',
                'reason' => 'Physical exercise has many benefits to brain health, such as by increasing blood flow to the brain, and along with diet, helps reduce weight and keep the whole body healthy.',
                'tips' => '',
                'is_active' => 1,
            ),
            '3' => array(
                'group_id' => '10',
                'category_id' => '103',
                'gif_name' => '<h5 class="topic__title topic__title--mental"><i class="icon-score icons_mental">&nbsp;</i>Mental </h5>',
                'second_advise' => 'engaging in a variety of <b>mentally stimulating activities</b> at least <b>4 times</b> a week.</b>',
                'reason' => 'Learning and applying new information, reading, solving puzzles, playing games, and exercising your creativity all help your brain stay fit and healthy.',
                'tips' => '',
                'is_active' => 1,
            ),
            '4' => array(
                'group_id' => '10',
                'category_id' => '104',
                'gif_name' => '<h5 class="topic__title topic__title--social"><i class="icon-score icons_social">&nbsp;</i>Social </h5>',
                'second_advise' => 'participating in <b>group events,</b> cultivating <b>new relationships,</b> and spending <b>quality time with friends.</b>',
                'reason' => 'Much like creative, analytical, and learning tasks, social engagement helps keep the brain fit, and the stress relieving benefits of social interaction is great for your health.',
                'tips' => '',
                'is_active' => 1,
            ),
            '5' => array(
                'group_id' => '20',
                'category_id' => '201',
                'gif_name' => '<h5 class="topic__title topic__title--fish"><i class="icon-score icons_fish">&nbsp;</i>Fish </h5>',
                'second_advise' => 'eating at least <b>5 servings of fish</b> (not including fried fish) per week.',
                'reason' => 'Many fish (like tuna and salmon) are rich in fatty acids (especially omega-3) that help reduce the risk developing brain health conditions like dementia. Fried fish do not have the same benefits.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Choose wild-caught fish when possible. Wild-caught fish is much higher in omega-3 fatty acids than farm-raised fish. </p></li><li class="tip__list__content"> <p class="tip__list--detail">Tuna sandwiches, salmon burgers, fish tacos, and fish burritos are easy and delicious ways to increase your weekly intake of fish. </p> </li><li class="tip__list__content"> <p class="tip__list--detail">Adding a variety of healthy herbs, spices, or chutneys can improve the taste of fish. Fennel, dill, turmeric, garlic, or lemon peels are a few simple ways to add great flavor.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Don’t care for a “fishy” taste? Try adding small pieces of cooked fish into a green salad, quinoa, or couscous.  Consider adding fish to a pasta dish along with your favorite tomato sauce.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Marinating fish prior to cooking helps to mask a strong fish flavor. Mustard, soy sauce, and lemon marinades are all great options.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Top omega-3 rich fish sources: salmon, sardine, herring, cod, roe, anchovy, black & red caviar, and mackerel are tasty varieties. Other types that provide moderate amounts of omega-3 fats include oysters, bass, capers, and sable fish. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Taking a high quality, mercury free fish oil supplement such as cod, menhaden, herring, krill, etc. is a great way to increase omega-3 intake.</p> </li> ',
                'is_active' => 1,
            ),
            '6' => array(
                'group_id' => '20',
                'category_id' => '202',
                'gif_name' => '<h5 class="topic__title topic__title--vegetables"><i class="icon-score icons_vegetables">&nbsp;</i>Vegetables </h5>',
                'second_advise' => 'eating servings of <b>vegetables every day.</b>',
                'reason' => 'Eating plenty of vegetables, which are rich in important nutrients like antioxidants, will help reduce your risk of declining brain health and dementia.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Baby carrots and celery sticks make a great snack. They have a nice crunch and are packed with vitamins. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Include dried fruits into your snack routine. They are full of vitamins, minerals, and fibers. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Eat one vegetable or fruit at breakfast every day. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Green smoothies are an easy and delicious way to sneak in 3-4 servings of fruits and vegetables each day.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Always have a fruit salad or a veggie platter in the refrigerator. This save time and encourages healthy snacking.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Strive to prepare healthy, home-cooked meals using a variety of vegetables. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Buy a variety of vegetables each time you shop.  Eating a variety of vegetables means you will be consuming a wide variety of nutrients and antioxidants. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Keep fresh fruits as a table décor; it encourages you to choose healthy eating as part of your routine. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Soups and pizzas are a great way to incorporate more veggies into your menu. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make a veggie kebob with squash, bell pepper, carrots, zucchini, and mushrooms. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Enjoy vegetables both raw and grilled depending on your taste.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Prepare a large batch of stir fry for lunch and save the leftovers to prepare a veggie muffin or egg casserole.</p> </li> ',
                'is_active' => 1,
            ),
            '7' => array(
                'group_id' => '20',
                'category_id' => '203',
                'gif_name' => '<h5 class="topic__title topic__title--redmeat"><i class="icon-score icons_redmeat">&nbsp;</i>Avoiding Red Meat </h5>',
                'second_advise' => 'eating <b>no more than 3 servings</b> of <b>red meat</b> per week.',
                'reason' => 'Medical research has linked over-consumption of red meat to increased risk for vascular disease and dementia.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Consider meal planning to help limit your intake of red meat. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Consider plant based proteins such as beans or legumes as a healthy alternative to red meat. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Choose to go meatless one day each week. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Try Asian cuisine! Thai, Chinese, and Indian menus incorporate more plant-based meals with less red meat. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Swap your red meat with sea foods like cold-water fish and oysters. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">If you eat red meat for protein, there are lots of other sources that give you ample protein. Beans, legumes, chicken, fish, and cottage cheese have plenty of protein. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Keep a food log or diary. This will help track and reduce the number of times your eat red meat in a week.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Tempeh, made from fermented soybeans, is an excellent vegetarian substitute for red meat. Season tempeh like you would red meat. Try topping salads with strips of tempeh. Use tempeh in a stir fry, or make Reuben sandwiches with tempeh instead of beef. It is a great source of protein, iron, zinc, phosphorous, B vitamins, and healthy fats, including omega-3 fats. </p> </li>',
                'is_active' => 1,
            ),
            '8' => array(
                'group_id' => '20',
                'category_id' => '204',
                'gif_name' => '<h5 class="topic__title topic__title--fruit"><i class="icon-score icons_fruit">&nbsp;</i>Fruit </h5>',
                'second_advise' => 'eating at least <b>3 servings</b> of </b>fruit and berries</b> per week.',
                'reason' => 'Eating fruits and berries has been linked to reduced risk for Alzheimer\'s disease and dementias.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Prepare fruit kebabs with a variety of colored fruits for parties or gatherings. Good combinations include strawberries, grapes, blueberries, and melons. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Keep washed and sliced fruits in the refrigerator for a quick snack.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add a variety of fresh fruits with a serving of protein powder to make a filling breakfast smoothie. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Grill fruits like pineapple, watermelon, apples, figs, cantaloupes, and peaches. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Consider convenience when shopping. Try pre-cut packages of fruit (such as melon or pineapple chunks) for a healthy snack in seconds. Choose packaged fruits that do not have added sugars. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Buy fruit that is in season. Seasonal produce tends to cost less and have better flavor. Your taste buds and pocket book will thank you! </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">When you have a sweet tooth, reach for a serving of dried fruits. They are naturally sweet and are rich in vitamins, minerals, and fiber. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Eat a serving of fruit salad each day. Use various fruit combinations to prevent taste fatigue and to consume a wide variety of nutrients.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">While choosing canned fruits, select fruit canned in 100% fruit juice or water rather than syrup. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Top your cereal with bananas or peaches; add blueberries to pancakes. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Mix fresh fruit with plain, fat-free or low-fat yogurt. </p> </li> ',
                'is_active' => 1,
            ),
            '9' => array(
                'group_id' => '20',
                'category_id' => '205',
                'gif_name' => '<h5 class="topic__title topic__title--chicken"><i class="icon-score icons_chicken">&nbsp;</i>Chicken </h5>',
                'second_advise' => 'eating at least <b>2 servings</b> of <b>chicken</b> per week.',
                'reason' => 'Eating poultry, including chicken and turkey, has been linked to reduced risk for Alzheimer\'s disease and other dementias.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Choose antibiotic-free, hormone-free chicken over factory-farmed chicken. If you are not sure about which product is best, buying organic chicken is always a great choice.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make your salad a high protein meal by adding a serving of chicken. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Enjoy grilled chicken with vegetable sides. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Try adding chicken to a pot of homemade soup. Chicken tortilla soup and chicken and wild rice are tasty options. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Ground turkey and chicken can replace beef in most casserole, meatball, and chili recipes. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Chicken is a versatile meat that can be added to a variety of dishes such as salads, enchiladas, burritos, soups, casseroles, and sandwiches.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Bake a few extra chicken breasts each week for a quick and healthy salad or sandwich.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Marinating chicken and turkey with spices improves flavor and also makes it more appetizing. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Try adding ground chicken to your homemade pizza. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Use ground chicken meat to make a great sandwich.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Crockpot cooking makes eating healthy a breeze. Add chicken, vegetables, and broth to your crock pot in the morning and come home to a nutritious meal. </p> </li> ',
                'is_active' => 1,
            ),
            '10' => array(
                'group_id' => '20',
                'category_id' => '206',
                'gif_name' => '<h5 class="topic__title topic__title--nuts"><i class="icon-score icons_nuts">&nbsp;</i>Nuts </h5>',
                'second_advise' => 'eating at least <b>5 servings</b> of <b>nuts</b> per week.',
                'reason' => 'Eating nuts has been linked to reduced risk for Alzheimer\'s disease and other dementias.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Nuts make for a crunchy, convenient snack. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Eat a handful of nuts every day. Cashews, almonds, pistachios, and walnuts are all great choices.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add peanuts or cashews to vegetable stir fry recipes. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Crushed nuts make for great topping on cereal, yogurt, ice cream, and pudding.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Peanut and almond butter taste great on whole grain toast. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Increase the flavor of nuts by lightly toasting them. Place nuts in a dry frying pan over medium to high heat for 3-5 minutes. Nuts can burn quickly, so watch them carefully. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add a nice crunch to fish fillets by sprinkling on chopped nuts, such as almonds or pine nuts, before baking. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Seeds can also provide omega-3 fats. Examples include chia and flax seeds. Spread tahini (from ground sesame seeds) on crackers or use it as a dip with fresh veggies. It is often found in hummus, but it is tasty on its own too. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Almond flour can replace all-purpose flour in a variety of baked dishes. </p> </li> ',
                'is_active' => 1,
            ),
            '11' => array(
                'group_id' => '20',
                'category_id' => '207',
                'gif_name' => '<h5 class="topic__title topic__title--grains"><i class="icon-score icons_grains">&nbsp;</i>Whole Grains </h5>',
                'second_advise' => 'eating <b>whole grain foods every day.</b>',
                'reason' => 'Eating whole grain foods, like whole grain bread, has been linked to reduced risk for Alzheimer\'s disease and other dementias.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Whole grain salads, such as tabbouleh, make a healthy and quick lunch. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Use whole grain flour instead of refined flour where possible. Switch half the white flour to whole wheat flour in your regular recipes for cookies, muffins, quick breads, and pancakes. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Replace one-third of the flour in a recipe with quick oats or old-fashioned oats. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add half a cup of cooked bulgur, wild rice, or barley to bread stuffing. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add half a cup of cooked wheat or rye berries, wild rice, brown rice, sorghum, or barley to your favorite canned or home-made soup. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Use whole corn meal for corn cakes, corn breads, and corn muffins. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add ¾ cup of uncooked oats for each pound of ground beef or turkey when you make meatballs, burgers, or meatloaf. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Stir a handful of rolled oats in your yogurt for a quick crunch with no cooking necessary. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make risottos, pilafs, and other rice-based dishes with whole grains such as barley, brown rice, bulgur, millet, quinoa, or sorghum. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Buy whole grain pasta or a blend that’s part whole grain, part white. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Try whole grain breads. Kids especially like whole grain pita bread. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Buy cereals made with whole grains like kamut, spelt, or kasha. </p> </li> ',
                'is_active' => 1,
            ),
            '12' => array(
                'group_id' => '20',
                'category_id' => '208',
                'gif_name' => '<h5 class="topic__title topic__title--sugar"><i class="icon-score icons_sugar">&nbsp;</i>Avoiding Sugars </h5>',
                'second_advise' => '<b>avoiding very sugary candy or drinks.</b>',
                'reason' => 'Diet research recommends avoiding pastries and sweets, and shows that the high sugar content in drinks like soda can increase the risk for conditions that are harmful to brain health.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Keep track of your sugar intake and try to set a goal for a week to cut back on sugar. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Sugar adds up quickly in beverages! Avoid soda, juice, and sports drinks. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Add sugar to your coffee? Try adding coconut milk, vanilla or cinnamon instead. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Enjoy high fiber foods such as whole grains, beans, etc. This helps to keep blood sugar stable and cuts the sugar cravings. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Coriander, cinnamon, nutmeg, cloves, and cardamom naturally sweeten foods and help reduce cravings. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Choose fruit as a dessert. Fruit is naturally sweetened and provides you with fiber, vitamins and antioxidants that will give you energy and improve the quality of your diet. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Avoid keeping sugary snacks within arm’s reach. It makes eating healthy difficult.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Watch out for foods with hidden sugar such as yogurt, ketchup, pasta sauce, salad dressings, etc. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Check food labels to see how much sugar has been added. Remember, 4 grams of sugar is equal to 1 teaspoon of sugar.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Keep a list of the other sneaky names for sugar in packaged foods. Some common ones are: high fructose corn syrup, dried cane syrup, invert sugar, molasses, sucrose (or any word ending in "-ose"), and brown rice syrup. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">One 12 oz. full calorie soda contains a whopping 10-12 teaspoons of sugar. Try choosing a flavored sparkling water instead. </p> </li> ',
                'is_active' => 1,
            ),
            '13' => array(
                'group_id' => '20',
                'category_id' => '209',
                'gif_name' => '<h5 class="topic__title topic__title--sweet"><i class="icon-score icons_sweet">&nbsp;</i>Avoiding Artificial Sweeteners </h5>',
                'second_advise' => '<b>avoiding artificial sweeteners.</b>',
                'reason' => 'Scientific research has shown that artificial sweeteners like aspartame can have serious harmful effects on brain health.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Be aware of various names given to artificial sweeteners – generic names include aspartame, sucralose, acesulfame potassium, or Ace K, and saccharin. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Carry a list of artificial sweeteners on your smart phone so you can check ingredient lists while shopping. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Artificial sweeteners are often found in yogurt, chewing gums, protein shakes, cereal, and flavored drinks. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Many processed foods are full of artificial sweeteners and harmful preservatives. Try to limit consumption of these chemicals by cooking more at home. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Cut back on prepackaged snacks.  Make your own snacks from simple ingredients to reduce your intake of artificial sweeteners.</p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Use sweetening spices like cinnamon bark or cardamom can add a sweet tinge to your dishes and cut back on the need for added sweeteners. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Prepackaged foods that contain artificial colors are likely to carry artificial sweeteners too. </p> </li>',
                'is_active' => 1,
            ),
            '14' => array(
                'group_id' => '20',
                'category_id' => '210',
                'gif_name' => '<h5 class="topic__title topic__title--olive"><i class="icon-score icons_olive">&nbsp;</i>Olive oil </h5>',
                'second_advise' => 'cooking with <b>olive oil several times</b> a week or more.',
                'reason' => 'Olive oil is a great source of monounsaturated fatty acids, which have been shown to reduce risk for brain health conditions like dementia.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Use olive oil in place of butter to scramble or fry eggs and cook omelets. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Use olive oil in marinades, sauce for meat, fish, poultry, and vegetables. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Just before serving cooked vegetables, drizzle olive oil to add more flavor to your dish. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make popcorn with olive oil. It makes for a healthy snack! </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Substitute 3 tablespoons of olive oil in recipes that call for ¼ cup of butter, or ¼ cup plus 1-2 tablespoon of olive oil in recipes that call for ½ cup of butter. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Brush olive oil on meats before grilling or broiling to seal in the flavor and juices and to create a crispy exterior. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Homemade pesto stays bright green longer with the addition of a thin layer of olive oil. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Pour a little olive oil into a shallow dish, add a small bit of crumbled feta cheese, and season with salt and pepper to create a delicious and healthy dip for whole grain bread. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Drizzle extra virgin olive oil over your veggie salad for enhanced flavors. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Light and heat can destroy the omega-3 content of your olive oil.  Always buy extra virgin olive oil in a dark container and store in a cool location. </p> </li> ',
                'is_active' => 1,
            ),
            '15' => array(
                'group_id' => '30',
                'category_id' => '301',
                'gif_name' => '<h5 class="topic__title topic__title--smoking"><i class="icon-score icons_smoking">&nbsp;</i>No smoking </h5>',
                'second_advise' => '<b>not smoking.</b>',
                'reason' => 'Smoking has been shown to increase risk for developing Alzheimer\'s disease, and is correlated with long-term cognitive decline. It\'s never too late to quit.',
                'tips' => '',
                'is_active' => 1,
            ),
            '16' => array(
                'group_id' => '30',
                'category_id' => '302',
                'gif_name' => '<h5 class="topic__title topic__title--drink"><i class="icon-score icons_drink">&nbsp;</i>Moderate Drinking </h5>',
                'second_advise' => '<b>drinking a moderate amount</b> of alcohol per week.',
                'reason' => 'Moderate drinking (1 to 2 alcoholic drinks per day) reduces the long-term rate of cognitive decline and risk for dementia, but these benefits disappear with heavy drinking.',
                'tips' => '',
                'is_active' => 1,
            ),
            '17' => array(
                'group_id' => '30',
                'category_id' => '303',
                'gif_name' => '<h5 class="topic__title topic__title--stress"><i class="icon-score icons_stress">&nbsp;</i>Stress </h5>',
                'second_advise' => 'deliberately managing and maintaining <b>good control</b> of your <b>stress.</b>',
                'reason' => 'Stress is harmful to the whole body as well as the brain. Maintaining good control of stress, through activities such as yoga, meditation, or regular physical exercise, can yield great benefits to brain health.',
                'tips' => '',
                'is_active' => 1,
            ),
            '18' => array(
                'group_id' => '30',
                'category_id' => '304',
                'gif_name' => '<h5 class="topic__title topic__title--sleep"><i class="icon-score icons_sleep">&nbsp;</i>Good Sleep</h5>',
                'second_advise' => 'getting <b>7 to 8 hours</b> of good, <b>restful sleep.</b>',
                'reason' => 'Too little, or restless, sleep can be harmful to your brain over time, as can too much sleep. For optimal brain health, it\'s recommended to get 7 to 8 hours of uninterrupted sleep per night.',
                'tips' => '<li class="tip__list__content"> <p class="tip__list--detail">Expose yourself to sunlight and eat breakfast every morning to maintain your circadian rhythm. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Getting exercise during the daytime helps you sleep better. Finish your exercise more than 5 hours before going to bed. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Keep your bedroom dark, and avoid bright lights within an hour before bedtime. Especially blue light from your tablet, computer, or TV screen may disturb your sleep. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make your bedroom environment comfortable. Keep the room ambience quiet and relaxing and control the room temperature so it’s not too warm. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Make sure you’re comfortable with your bedroom amenities, including pajamas, pillows, and your mattress. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Go to bed when you are truly sleepy. Try not to use your bed for unrelated activities to prevent associating your bed with staying awake. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Avoid caffeine, alcohol and cigarettes in the late afternoon or evening to get a great night’s sleep. </p> </li> <li class="tip__list__content"> <p class="tip__list--detail">Consider going to a sleep clinic and consulting a sleep specialist if your severe insomnia or daytime sleepiness lasts for more than a month. Medication is available and can be effective at improving your sleep. </p> </li>',
                'is_active' => 1,
            ),
            '19' => array(
                'group_id' => '40',
                'category_id' => '401',
                'gif_name' => '<h5 class="topic__title topic__title--atrial"><i class="icon-score icons_atrial">&nbsp;</i>Atrial Fibrillation </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>atrial fibrillation.</b>',
                'reason' => 'Atrial fibrillation has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '20' => array(
                'group_id' => '40',
                'category_id' => '402',
                'gif_name' => '<h5 class="topic__title topic__title--artery"><i class="icon-score icons_artery">&nbsp;</i>Coronary Artery Disease </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>coronary artery disease.</b>',
                'reason' => 'Coronary artery disease has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '21' => array(
                'group_id' => '40',
                'category_id' => '403',
                'gif_name' => '<h5 class="topic__title topic__title--boring"><i class="icon-score icons_boring">&nbsp;</i>Depression </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>depression.</b>',
                'reason' => 'Depression has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '22' => array(
                'group_id' => '40',
                'category_id' => '404',
                'gif_name' => '<h5 class="topic__title topic__title--diabetes"><i class="icon-score icons_diabetes">&nbsp;</i>Diabetes </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>diabetes.</b>',
                'reason' => 'Diabetes has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '23' => array(
                'group_id' => '40',
                'category_id' => '405',
                'gif_name' => '<h5 class="topic__title topic__title--attack"><i class="icon-score icons_attack">&nbsp;</i>Heart Attack </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your risks for <b>heart attack.</b>',
                'reason' => 'Heart attack has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '24' => array(
                'group_id' => '40',
                'category_id' => '406',
                'gif_name' => '<h5 class="topic__title topic__title--hypertension"><i class="icon-score icons_hypertension">&nbsp;</i>Hypertension </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your </b>blood pressure.</b>',
                'reason' => 'Hypertension has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '25' => array(
                'group_id' => '40',
                'category_id' => '407',
                'gif_name' => '<h5 class="topic__title topic__title--cholesterol"><i class="icon-score icons_cholesterol">&nbsp;</i>Cholesterol </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>cholesterol.</b>',
                'reason' => 'High cholesterol has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '26' => array(
                'group_id' => '40',
                'category_id' => '408',
                'gif_name' => '<h5 class="topic__title topic__title--sleepapnea"><i class="icon-score icons_sleepapnea">&nbsp;</i>Sleep Apnea </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>sleep apnea.</b>',
                'reason' => 'Sleep apnea has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '27' => array(
                'group_id' => '40',
                'category_id' => '409',
                'gif_name' => '<h5 class="topic__title topic__title--stroke"><i class="icon-score icons_stroke">&nbsp;</i>Stroke </h5>',
                'second_advise' => 'maintaining <b>good control</b> of your <b>stroke.</b>',
                'reason' => 'Stroke has been found in scientific studies to increase the risk of long term brain health decline. It is important to control your risk with treatment. Ask your doctor for more information.',
                'tips' => '',
                'is_active' => 1,
            ),
            '28' => array(
                'group_id' => '50',
                'category_id' => '501',
                'gif_name' => '',
                'second_advise' => '',
                'reason' => 'As you grow older, your risk increases for conditions that affect brain health, so it becomes increasingly important to combat that risk with healthy activity, lifestyle, and diet.',
                'tips' => '',
                'is_active' => 1,
            ),
            '29' => array(
                'group_id' => '50',
                'category_id' => '502',
                'gif_name' => '',
                'second_advise' => '',
                'reason' => 'Higher education and continuous learning produce a cognitive reserve that helps protect you against the risks of declining brain health.',
                'tips' => '',
                'is_active' => 1,
            ),
            '30' => array(
                'group_id' => '50',
                'category_id' => '503',
                'gif_name' => '',
                'second_advise' => '',
                'reason' => 'A history of smoking can put you at risk for conditions that affect brain health. If you have smoked in the past, it\'s that much more important to counteract that with healthy activity, lifestyle, and diet.',
                'tips' => '',
                'is_active' => 1,
            ),
        );

        $this->assessmentSecondSentence->insert($data);
    }
}
