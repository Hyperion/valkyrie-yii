<?php
$this->breadcrumbs = array(
    'Game' => array('/wow/'),
    'Characters' => array('/wow/character/'),
    Database::$realm . ' @ ' . $model->name,
);
?>

<div>Средний (<?php echo $model->itemLevel['avg']; ?> Экипирован) <?php echo $model->itemLevel['avg']; ?></div>
<?php $this->renderPartial('_advanced', array('model' => $model)); ?>
<?php $this->renderPartial('_recent_activity', array('model' => $model)); ?>
<div class="summary-bottom-left">
    <div class="summary-talents" id="summary-talents">
        <ul>
            <li class="summary-talents-1">
                <a href="<?php echo $this->createUrl('/wow/character/talents', array('name'  => $model->name, 'realm' => Database::$realm)); ?>" rel="np" class="active">
                    <span class="inner">
                        <span class="icon">
                            <img src="http://eu.battle.net/wow-assets/static/images/icons/36/<?php echo $model->talents['icon']; ?>.jpg" alt="" />
                            <span class="frame"></span>
                        </span>
                        <span class="roles"></span>
                        <span class="name-build">
                            <span class="name"><?php echo $model->talents['name'] ?></span>
                            <span class="build">
                                <?php echo $model->talents[0]['count']; ?>
                                <ins>/</ins>
                                <?php echo $model->talents[1]['count']; ?>
                                <ins>/</ins>
                                <?php echo $model->talents[2]['count']; ?>
                            </span>
                        </span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <div class="summary-health-resource">
        <ul>
            <li class="health" id="summary-health" data-id="health">
                <span class="name">Health</span>
                <span class="value"><?php echo (is_object($model->stats)) ? $model->stats->maxhealth : $model->power1; ?></span>
            </li>
            <li class="resource-<?php echo $model->powerType; ?>" id="summary-power" data-id="power-<?php echo$model->powerType; ?>">
                <span class="name"><?php echo $model::itemAlias('powers', $model->powerType); ?></span>
                <span class="value"><?php echo $model->powerValue; ?></span>
            </li>
        </ul>
    </div>
    <div class="summary-stats-profs-bgs">
        <div class="summary-stats" id="summary-stats">
            <?php
            switch($this->action->id)
            {
                case 'simple': default:
                    //$this->renderPartial('_stats_simple', array('model' => $model->stats));
                    break;
            }

            //$this->renderPartial('_stats_js', array('model' => $model->stats));
            ?>
        </div>
        <?php $this->renderPartial('_bg_professions', array('model' => $model)); ?>
    </div>
</div>

<script type="text/javascript">
    //<![CDATA[
    var MsgSummary = {
        viewOptions: {
            threed: {
                title: "Модель в 3D"
            }
        },
        inventory: {
            slots: {
                1: "Голова",
                2: "Шея",
                3: "Плечи",
                4: "Рубашка",
                5: "Грудь",
                6: "Пояс",
                7: "Ноги",
                8: "Ступни",
                9: "Запястья",
                10: "Руки",
                11: "Палец",
                12: "Аксессуар",
                15: "Дальний бой",
                16: "Спина",
                19: "Гербовая накидка",
                21: "Правая рука",
                22: "Левая рука",
                28: "Реликвия",
                empty: "Эта ячейка пуста"
            }
        },
        audit: {
            whatIsThis: "С помощью этой функции вы можете узнать, как улучшить характеристики своего персонажа. Функция ищет:<br /\><br /\>- пустые ячейки символов;<br /\>- неиспользованные очки талантов;<br /\>- незачарованные предметы;<br /\>- пустые гнезда для самоцветов;<br /\>- неподходящую броню;<br /\>- отсутствующую пряжку в поясе;<br /\>- отсутствующие бонусы за профессии.",
            missing: "Не хватает: {0}",
            enchants: {
                tooltip: "Не зачаровано"
            },
            armor: {
                tooltip: "Не{0}",
                1: "Ткань",
                2: "Кожа",
                3: "Кольчуга",
                4: "Латы"
            },
            lowLevel: {
                tooltip: "Низкий уровень"
            },
            enchanting: {
                name: "Наложение чар",
                tooltip: "Не зачаровано"
            },
            engineering: {
                name: "Инженерное дело",
                tooltip: "Нет улучшения"
            },
            leatherworking: {
                name: "Кожевенное дело",
                tooltip: "Не зачаровано"
            }
        },
        talents: {
            specTooltip: {
                title: "Специализация",
                primary: "Основная:",
                secondary: "Второстепенная:",
                active: "Активная"
            }
        },
        stats: {
            toggle: {
                all: "Показать все характеристики",
                core: "Показать только основные характеристики"
            },
            increases: {
                attackPower: "Увеличивает силу атаки на {0}.",
                critChance: "Увеличивает шанс критического удара {0}%.",
                spellCritChance: "Увеличивает шанс нанесения критического урона магией на {0}%.",
                health: "Увеличивает здоровье на {0}.",
                mana: "Увеличивает количество маны на {0}.",
                manaRegen: "Увеличивает восполнение маны на {0} ед. каждые 5 сек., пока не произносятся заклинания.",
                meleeDps: "Увеличивает урон, наносимый в ближнем бою, на {0} ед. в секунду.",
                rangedDps: "Увеличивает урон, наносимый в дальнем бою, на {0} ед. в секунду.",
                petArmor: "Увеличивает броню питомца на {0} ед.",
                petAttackPower: "Увеличивает силу атаки питомца на {0} ед.",
                petSpellDamage: "Увеличивает урон от заклинаний питомца на {0} ед.",
                petAttackPowerSpellDamage: "Увеличивает силу атаки питомца на {0} ед. и урон от его заклинаний на {1} ед."
            },
            decreases: {
                damageTaken: "Снижает получаемый физический урон на {0}%.",
                enemyRes: "Снижает сопротивляемость противника на {0} ед.",
                dodgeParry: "Снижает вероятность того, что ваш удар будет парирован или от вашего удара уклонятся, на {0}%."
            },
            noBenefits: "Не предоставляет бонусов вашему классу.",
            beforeReturns: "(До снижения действенности повторяющихся эффектов)",
            damage: {
                speed: "Скорость атаки (сек.):",
                damage: "Урон:",
                dps: "Урон в сек.:"
            },
            averageItemLevel: {
                title: "Уровень предмета {0}",
                description: "Средний уровень вашего лучшего снаряжения. С его повышением вы сможете вставать в очередь в более сложные для прохождения подземелья."
            },
            health: {
                title: "Здоровье {0}",
                description: "Максимальный запас здоровья. Когда запас здоровья падает до нуля, вы погибаете."
            },
            mana: {
                title: "Мана {0}",
                description: "Максимальный запас маны. Мана расходуется на произнесение заклинаний."
            },
            rage: {
                title: "Ярость {0}",
                description: "Максимальный запас ярости. Ярость расходуется при применении способностей и накапливается, когда персонаж атакует врагов или получает урон."
            },
            energy: {
                title: "Энергия {0}",
                description: "Максимальный запас энергии. Энергия расходуется при применении способностей и восстанавливается со временем."
            },
            strength: {
                title: "Сила {0}"
            },
            agility: {
                title: "Ловкость {0}"
            },
            stamina: {
                title: "Выносливость {0}"
            },
            intellect: {
                title: "Интеллект {0}"
            },
            spirit: {
                title: "Дух {0}"
            },
            meleeDps: {
                title: "Урон в секунду"
            },
            meleeAttackPower: {
                title: "Сила атаки в ближнем бою {0}"
            },
            meleeSpeed: {
                title: "Скорость атаки в ближнем бою {0}"
            },
            meleeCrit: {
                title: "Рейтинг критического удара в ближнем бою {0}%",
                description: "Шанс нанести дополнительный урон в ближнем бою."
            },
            rangedDps: {
                title: "Урон в секунду"
            },
            rangedAttackPower: {
                title: "Сила атаки в дальнем бою {0}"
            },
            rangedSpeed: {
                title: "Скорость атаки в дальнем бою {0}"
            },
            rangedCrit: {
                title: "Рейтинг критического удара в дальнем бою {0}%",
                description: "Шанс нанести дополнительный урон в дальнем бою."
            },
            spellPower: {
                title: "Сила заклинаний {0}",
                description: "Увеличивает урон и исцеляющую силу заклинаний."
            },
            spellCrit: {
                title: "Вероятность критического эффекта заклинания {0}%",
                description: "Шанс нанести заклинанием дополнительный урон или исцеление."
            },
            manaRegen: {
                title: "Восполнение маны",
                description: "{0} ед. маны восполняется раз в 5 сек. вне боя."
            },
            combatRegen: {
                title: "Восполнение в бою",
                description: "{0} ед. маны восполняется раз в 5 сек. в бою."
            },
            armor: {
                title: "Броня {0}"
            },
            dodge: {
                title: "Шанс уклонения {0}%",
            },
            parry: {
                title: "Шанс парировать удар {0}%",
            },
            block: {
                title: "Шанс блокирования {0}%",
                description: "Блокирование останавливает {0}% наносимого вам урона."
            },
            arcaneRes: {
                title: "Сопротивление тайной магии {0}",
                description: "Снижает урон от тайной магии в среднем на {0}%."
            },
            fireRes: {
                title: "Сопротивление магии огня {0}",
                description: "Снижает урон от магии огня в среднем на {0}%."
            },
            frostRes: {
                title: "Сопротивление магии льдя {0}",
                description: "Снижает урон от магии льдя в среднем на {0}%."
            },
            natureRes: {
                title: "Сопротивление силам природы {0}",
                description: "Снижает урон от сил природы в среднем на {0}%."
            },
            shadowRes: {
                title: "Сопротивление темной магии {0}",
                description: "Снижает урон от темной магии в среднем на {0}%."
            }
        },
        recentActivity: {
            subscribe: "Подписаться на эту ленту новостей"
        },
        raid: {
            tooltip: {
                normal: "(норм.)",
                heroic: "(героич.)",
                players: "{0} игроков",
                complete: "{0}% завершено ({1}/{2})",
                optional: "(на выбор)",
                expansions: {
                    0: "Классика",
                    1: "The Burning Crusade",
                    2: "Wrath of the Lich King",
                    3: "Cataclysm"
                }
            },
            expansions: {
                0: "Классика",
                1: "The Burning Crusade",
                2: "Wrath of the Lich King",
                3: "Cataclysm"
            }
        }
    };
    //]]>
</script>
